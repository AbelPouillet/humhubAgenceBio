<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\search\engine;

use humhub\modules\calendar\models\CalendarEntry;
use Yii;
use yii\base\Component;
use humhub\modules\search\interfaces\Searchable;
use humhub\modules\content\models\Content;
use humhub\modules\content\models\ContentTag;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\user\models\User;
use humhub\modules\space\models\Space;
use humhub\modules\search\events\SearchAttributesEvent;
use humhub\modules\cet_entite\models\Entite;
use humhub\modules\cet_commune\models\CetCommune;

/**
 * Description of HSearchComponent
 *
 * @since 0.12
 * @author luke
 */
abstract class Search extends Component
{

    const EVENT_SEARCH_ATTRIBUTES = 'search_attributes';
    const EVENT_ON_REBUILD = 'onRebuild';
    const DOCUMENT_TYPE_USER = 'user';
    const DOCUMENT_TYPE_CET_ENTITE = 'cet_entite';
    const DOCUMENT_TYPE_SPACE = 'space';
    const DOCUMENT_TYPE_EVENT = 'event';
    const DOCUMENT_TYPE_CONTENT = 'content';
    const DOCUMENT_TYPE_OTHER = 'other';
    const DOCUMENT_VISIBILITY_PUBLIC = 'public';
    const DOCUMENT_VISIBILITY_PRIVATE = 'private';

    /**
     * @var int the minimum length of a search token
     */
    public $minQueryTokenLength = 1;

    /**
     * Retrieves results from search
     *
     * Available options:
     *      page
     *      pageSize
     *
     *      sortField           Mixed String/Array
     *      model               Mixed String/Array
     *      type                Mixed String/Array
     *      checkPermissions    boolean (TRUE/false)
     *      limitSpaces         Array (Limit Content to given Spaces(
     *      filters             Array (Additional filter Field=>Value)
     *
     * @param type $query
     * @param array $options
     * @return SearchResultSet
     */
    abstract public function find($query, array $options);

    /**
     * Stores an object in search index.
     *
     * @param Searchable $object
     */
    abstract public function add(Searchable $object);

    /**
     * Updates an object in search index.
     *
     * @param Searchable $object
     */
    abstract public function update(Searchable $object);

    /**
     * Deletes an object from search.
     *
     * @param Searchable $object
     */
    abstract public function delete(Searchable $object);

    /**
     * Deletes all objects from search index.
     */
    abstract public function flush();

    /**
     * Rebuilds search index
     */
    public function rebuild()
    {
        //print "rebuild search index: launch \n";
        $this->flush();
        //print "search index deleted \n";
        $this->trigger(self::EVENT_ON_REBUILD);
        //print "triggered event \n";
        $this->optimize();
        //print "search index optimized \n";
    }

    /**
     * Optimizes the search index.
     * Default implementation does nothing, may be overidden by child classes.
     */
    public function optimize()
    {
    }

    public function coordToString($coord)
    {
        //print("on passe ici \n");
        $coordPositive = floatval($coord) + 200;
        $coordstr = strval($coordPositive);
        if (str_contains($coordstr, '.')) {
            $coordArray = explode('.', $coordstr);
            if (isset($coordArray[1])) {

                if (strlen($coordArray[1]) > 7) {
                    $coordArray[1] = substr($coordArray[1], 0, 7);
                }
                while (strlen($coordArray[1]) < 7) {
                    $coordArray[1] .= '0';
                }
                $coordstr = $coordArray[0] . $coordArray[1];
                while (strlen($coordstr) < 10) {
                    $coordstr = '0' . $coordstr;
                }
            }
        } else {
            while (strlen($coordstr) < 10) {
                $coordstr .= '0';
            }
        }
        //print($coordstr);
        return $coordstr;
    }

    protected function getMetaInfoArray(Searchable $obj)
    {
        $meta = [];
        $meta['type'] = $this->getDocumentType($obj);
        $meta['pk'] = $obj->getPrimaryKey();
        $meta['model'] = $obj->className();

        if ($obj instanceof ContentContainerActiveRecord) {
            $meta['containerModel'] = $obj->className();
            $meta['containerPk'] = $obj->id;
        }
        //Tableau de trie par date
        if ($obj instanceof CalendarEntry) {
            $meta['timestamp'] = strtotime($obj['start_datetime']);
        }
        // reconstruction l'index suite aux modifications du tableau meta
        if ($obj instanceof Entite) {
            //isCertifier
            $meta['contentTags'] = "";
            foreach($obj->getEntiteTags()->all() as $tag){
                $meta['contentTags'] .= $tag->nom . " ";
            }
            $isCertifier = false;
            foreach ($obj->certificats as $certificat) {
                if ($certificat->etatCertification == "ENGAGEE") {
                    $isCertifier = true;
                }
            }
            $meta['isCertifier'] = $isCertifier ? "true" : "false";
            //_idCommuneDistanceKM_
            //$meta['distanceCommune'] = "_";

            $meta['distanceCommune40'] = "_";
            $meta['distanceCommune30'] = "_";
            $meta['distanceCommune20'] = "_";
            $meta['distanceCommune10'] = "_";
            /*$latmin = '3000000000';
            $longmin = '3000000000';
            $latmax = '0';
            $longmax = '0';
            foreach ($obj->adresses as $adresse) {
                if (isset($adresse)) {
                    $currentLat = $this->coordToString($adresse->lat);
                    $currentLong = $this->coordToString($adresse->long);
                    if (intval($currentLat) < intval($latmin)) {
                        $latmin = $currentLat;
                    }
                    if (intval($currentLat) > intval($latmax)) {
                        $latmax = $currentLat;
                    }
                    if (intval($currentLong) < intval($longmin)) {
                        $longmin = $currentLong;
                    }
                    if (intval($currentLong) > intval($longmax)) {
                        $longmax = $currentLong;
                    }
                }
            }
            $meta['latmin'] = $latmin;
            $meta['longmin'] = $longmin;
            $meta['latmax'] = $latmax;
            $meta['longmax'] = $longmax;
            */

            foreach (CetCommune::find()->all() as $commune) {
                //TODO: Séparation en zone
                //Calcul de la distance $distanceKM
                foreach ($obj->adresses as $adresse) {
                    $distanceKM = $this->distance($adresse->lat, $adresse->long, $commune->Latitude, $commune->Longitude);
                    //print 'distance entre ' . $obj->raisonSociale . ' et ' . $commune->commune . ' est calculer à ' . $distanceKM . " KM \n";
                    if ($distanceKM <= 40 && $distanceKM > 30) {
                        $meta['distanceCommune40'] .= $commune->id . '_';
                    }
                    if ($distanceKM <= 30 && $distanceKM > 20) {
                        $meta['distanceCommune30'] .= $commune->id . '_';
                    }
                    if ($distanceKM <= 20 && $distanceKM > 10) {
                        $meta['distanceCommune20'] .= $commune->id . '_';
                    }
                    if ($distanceKM <= 10) {
                        $meta['distanceCommune10'] .= $commune->id . '_';
                    }
                }
            }
            $meta['activitesId'] = "_";
            foreach ($obj->activites as $activite) {
                $meta['activitesId'] .= $activite->id . "_";
            }
            $meta['categoriesId'] = "_";
            foreach ($obj->categories as $categorie) {
                $meta['categoriesId'] .= $categorie->id . "_";
            }
            // Ajout des type
            $meta['typesId'] = "_";
            foreach ($obj->cetTypes as $type) {
                $meta['typesId'] .= $type->id . "_";
            }
            //print($obj->denominationcourante . " ajout de ses activites et categories dans le tableau meta recherches .\n");
        }

        // Add content related meta data
        if ($meta['type'] == self::DOCUMENT_TYPE_CONTENT) {
            if ($obj->content->container !== null) {
                $meta['containerModel'] = $obj->content->container->className();
                $meta['containerPk'] = $obj->content->container->id;
            }
            if ($obj->content->visibility == Content::VISIBILITY_PUBLIC) {
                $meta['visibility'] = self::DOCUMENT_VISIBILITY_PUBLIC;
            } else {
                $meta['visibility'] = self::DOCUMENT_VISIBILITY_PRIVATE;
            }

            $meta['contentTags'] = implode(', ', array_map(function (ContentTag $tag) {
                return $tag->name;
            }, $obj->content->tags));
        } elseif ($meta['type'] == self::DOCUMENT_TYPE_SPACE && $obj->visibility == Space::VISIBILITY_NONE) {
            $meta['visibility'] = self::DOCUMENT_VISIBILITY_PRIVATE;
        } else {
            $meta['visibility'] = self::DOCUMENT_VISIBILITY_PUBLIC;
        }

        return $meta;
    }

    protected function getDocumentType(Searchable $obj)
    {
        if ($obj instanceof Space) {
            return self::DOCUMENT_TYPE_SPACE;
        } elseif ($obj instanceof User) {
            return self::DOCUMENT_TYPE_USER;
        } elseif ($obj instanceof CalendarEntry) {
            return self::DOCUMENT_TYPE_EVENT;
        } elseif ($obj instanceof Entite) {
            return self::DOCUMENT_TYPE_CET_ENTITE;
        } elseif ($obj instanceof ContentActiveRecord) {
            return self::DOCUMENT_TYPE_CONTENT;
        } else {
            return self::DOCUMENT_TYPE_OTHER;
        }
    }

    protected function setDefaultFindOptions($options)
    {
        if (!isset($options['page']) || $options['page'] == '') {
            $options['page'] = 1;
        }

        if (!isset($options['pageSize']) || $options['pageSize'] == '') {
            $options['pageSize'] = Yii::$app->settings->get('paginationSize');
        }

        if (!isset($options['checkPermissions'])) {
            $options['checkPermissions'] = true;
        }

        if (!isset($options['limitSpaces'])) {
            $options['limitSpaces'] = [];
        }

        if (!isset($options['limitActivites'])) {
            $options['limitActivites'] = [];
        }

        return $options;
    }

    /**
     * Returns additional search attributes for the given object.
     * This contains a list of comments, files and other content addons.
     *
     * @param Searchable $object
     * @return array the additional search attributes
     */
    protected function getAdditionalAttributes(Searchable $object)
    {
        $additionalAttributes = [];
        $this->trigger(self::EVENT_SEARCH_ATTRIBUTES, new SearchAttributesEvent($additionalAttributes, $object));

        return $additionalAttributes;
    }

    protected function distance($lat1, $lng1, $lat2, $lng2, $miles = false)
    {
        //print "Calcul de distance ... \n";
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lng1 *= $pi80;
        $lat2 *= $pi80;
        $lng2 *= $pi80;

        $r = 6372.797; // rayon moyen de la Terre en km
        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin(
            $dlng / 2
        ) * sin($dlng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        return ($miles ? ($km * 0.621371192) : $km);
    }
}
