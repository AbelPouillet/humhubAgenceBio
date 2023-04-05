<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\search\controllers;

use humhub\modules\cet_categorie\models\Categorie;
use humhub\modules\user\widgets\Image;
use Yii;
use yii\data\Pagination;
use humhub\components\Controller;
use humhub\modules\cet_activite\models\Activite;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use humhub\modules\search\models\forms\SearchForm;
use humhub\modules\search\engine\Search;
use humhub\modules\cet_entite\models\Entite;

use humhub\modules\cet_commune\models\CetCommune;
use humhub\modules\cet_type\models\Type;
use yii\helpers\ArrayHelper;

/**
 * Search Controller provides search functions inside the application.
 *
 * @author Luke
 * @since 0.12
 */
class SearchController extends Controller
{
    /**
     * View context used for the search view
     * @see View::$viewContext
     */
    const VIEW_CONTEXT = 'search';

    /**
     * @var string the current search keyword
     */
    public static $keyword = '';

    /**
     * Display map for the search
     *
     */
    public $displayMap;
    /**
     * @inheritdoc
     */
    public $showResults = false;

    public $distanceRecherche = 10;

    public $isCertifier = false;

    public $startDatetime = '';

    public $endDatetime = '';

    public function init()
    {
        $this->appendPageTitle(\Yii::t('SearchModule.base', 'Search'));
        $this->view->setViewContext(static::VIEW_CONTEXT);
        return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['login']
        ];
    }
    public function actionTableauentite()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '300');
        $model = new SearchForm();
        $model->load(Yii::$app->request->get());

        if ($model->scope == SearchForm::SCOPE_CET_ENTITE) {
            $type = SearchForm::SCOPE_CET_ENTITE;
            $displayMap = true;
        }
        $dataActivites = [];
        $activites = Activite::find()->select('id, nom')->all();
        $dataActivites = ArrayHelper::map($activites, 'id', 'nom');
        $limitActivites = [];
        $valueActivites = [];
        if (!empty($model->limitActivitesIds)) {
            foreach ($model->limitActivitesIds as $id) {
                $activite = Activite::findOne(['id' => trim($id)]);
                if ($activite !== null) {
                    $limitActivites[] = $activite;
                    $valueActivites[] = [$id => $activite->nom];
                }
            }
            $this->showResults = true;
        }
        $dataCategories = [];
        $categories = Categorie::find()->select('id, nom')->all();
        $dataCategories = ArrayHelper::map($categories, 'id', 'nom');
        $limitCategories = [];
        $valueCategories = [];
        if (!empty($model->limitCategoriesIds)) {
            foreach ($model->limitCategoriesIds as $id) {
                $categorie = Categorie::findOne(['id' => trim($id)]);
                if ($categorie !== null) {
                    $limitCategories[] = $categorie;
                    $valueCategories[] = [$id => $categorie->nom];
                }
            }
            $this->showResults = true;
        }
        $dataTypes = [];
        $types = Type::find()->select('id, nom')->all();
        $dataTypes = ArrayHelper::map($types, 'id', 'nom');

        $limitTypes = [];
        $valueTypes = [];
        if (!empty($model->limitTypesIds)) {
            foreach ($model->limitTypesIds as $id) {
                $type = Type::findOne(['id' => trim($id)]);
                if ($type !== null) {
                    $limitTypes[] = $type;
                    $valueTypes[] = [$id => $type->nom];
                }
            }
            $this->showResults = true;
        }
        $limitCommunes = [];
        $this->distanceRecherche = $model->distanceRecherche;
        if (!empty($model->limitCommunesIds)) {
            foreach ($model->limitCommunesIds as $id) {
                $commune = CetCommune::findOne(['id' => trim($id)]);
                if ($commune !== null) {
                    $limitCommunes[] = $commune;
                }
            }
            $this->showResults = true;
        }
        $optionsMap = [
            'page' => 0,
            'sortField' => '',
            'pageSize' => 40000,
            'limitSpaces' => [],
            'limitActivites' => $limitActivites,
            'limitCommunes' => $limitCommunes,
            'limitCategories' => $limitCategories,
            'limitTypes' => $limitTypes,
            'distanceRecherche' => $this->distanceRecherche,
            'isCertifier' => $this->isCertifier,
            'displayMap' => $displayMap,
            'model' => '',
            'type' => $type,
            'displayEvent' => false,
        ];
        $searchMapResultSet =  Yii::$app->search->find($model->keyword, $optionsMap);
        $resultMap = $searchMapResultSet->getResultInstances();
        $tableauEnString = "<html><head></head><table><thead><tr><td>Num</td><td>Producteur</td><td>Adresse1</td><td>Adresse2</td><td>Adresse3</td><td>Type</td><td>Personne</td><td>Email</td><td>Tel 1</td><td>Tel 2</td></tr></thead><tbody>";
        foreach ($resultMap as $resMap) {
            $tableauEnString .= $resMap->getEntiteEnTableau();
        }
        $tableauEnString .= "</tbody></table></html>";
        echo $tableauEnString;
    }
    public function actionNewsletter()
    {
        //TODO télécharger le fichier contenant les évènements de la période données
        //On récupère le model
        $model = new SearchForm();
        $model->load(Yii::$app->request->get());
        if (!empty($model->startDatetime)) {
            $this->startDatetime = $model->startDatetime;
            $this->showResults = true;
        } else {
            $this->startDatetime = date('d-m-Y');
            $model->startDatetime = $this->startDatetime;
            //print ($this->startDatetime);

        }

        if (!empty($model->endDatetime)) {
            $this->endDatetime = $model->endDatetime;
            $this->showResults = true;
        }
        if ($model->scope == SearchForm::SCOPE_EVENT) {
            $type = Search::DOCUMENT_TYPE_EVENT;
            $displayEvent = true;
            $sortField = '';
        }
        $optionsEvent = [
            'page' => 0,
            'sortField' => $sortField,
            'pageSize' => 40000,
            'limitSpaces' => [],
            'limitActivites' => [],
            'limitCommunes' => [],
            'limitCategories' => [],
            'limitTypes' => [],
            'distanceRecherche' => $this->distanceRecherche,
            'isCertifier' => $this->isCertifier,
            'displayEvent' => $displayEvent,
            'model' => '',
            'type' => $type,
            'startDatetime' => $this->startDatetime,
            'endDatetime' => $this->endDatetime,
        ];

        $searchEventResultSet =  Yii::$app->search->find($model->keyword, $optionsEvent);
        $result = $searchEventResultSet->getResultInstances();
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="download.html"');
        $text = "<head><style type='css'>    </style></head>";
        $text .= "<h1> Liste des évènements du " . $this->startDatetime . " au " . $this->endDatetime . " : </h1>";
        foreach ($result as $event) {
            $text .= /*var_dump($result); */ $event->getWallNewsletter();
        }
        echo $text;
        exit;
    }
    public function actionIndex()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '300');
        $model = new SearchForm();
        $model->load(Yii::$app->request->get());
        if (!isset($_SESSION['result'])) {
            $_SESSION['result'] = [];
        }
        $limitSpaces = [];
        if (!empty($model->limitSpaceGuids)) {
            foreach ($model->limitSpaceGuids as $guid) {
                $space = Space::findOne(['guid' => trim($guid)]);
                if ($space !== null) {
                    $limitSpaces[] = $space;
                }
            }
        }
        $dataActivites = [];
        $activites = Activite::find()->select('id, nom')->all();
        $dataActivites = ArrayHelper::map($activites, 'id', 'nom');
        $limitActivites = [];
        $valueActivites = [];
        if (!empty($model->limitActivitesIds)) {
            foreach ($model->limitActivitesIds as $id) {
                $activite = Activite::findOne(['id' => trim($id)]);
                if ($activite !== null) {
                    $limitActivites[] = $activite;
                    $valueActivites[] = [$id => $activite->nom];
                }
            }
            $this->showResults = true;
        }
        $dataCategories = [];
        $categories = Categorie::find()->select('id, nom')->all();
        $dataCategories = ArrayHelper::map($categories, 'id', 'nom');
        $limitCategories = [];
        $valueCategories = [];
        if (!empty($model->limitCategoriesIds)) {
            foreach ($model->limitCategoriesIds as $id) {
                $categorie = Categorie::findOne(['id' => trim($id)]);
                if ($categorie !== null) {
                    $limitCategories[] = $categorie;
                    $valueCategories[] = [$id => $categorie->nom];
                }
            }
            $this->showResults = true;
        }
        $dataTypes = [];
        $types = Type::find()->select('id, nom')->all();
        $dataTypes = ArrayHelper::map($types, 'id', 'nom');

        $limitTypes = [];
        $valueTypes = [];
        if (!empty($model->limitTypesIds)) {
            foreach ($model->limitTypesIds as $id) {
                $type = Type::findOne(['id' => trim($id)]);
                if ($type !== null) {
                    $limitTypes[] = $type;
                    $valueTypes[] = [$id => $type->nom];
                }
            }
            $this->showResults = true;
        }
        $limitCommunes = [];
        $this->distanceRecherche = $model->distanceRecherche;
        if (!empty($model->limitCommunesIds)) {
            foreach ($model->limitCommunesIds as $id) {
                $commune = CetCommune::findOne(['id' => trim($id)]);
                if ($commune !== null) {
                    $limitCommunes[] = $commune;
                }
            }
            $this->showResults = true;
        }
        if (!empty($model->isCertifier)) {
            $this->isCertifier = $model->isCertifier;
            $this->showResults = true;
        }

        if (!empty($model->startDatetime)) {
            $this->startDatetime = $model->startDatetime;
            $this->showResults = true;
        } else {
            $this->startDatetime = date('d-m-Y');
            $model->startDatetime = $this->startDatetime;
            //print ($this->startDatetime);

        }

        if (!empty($model->endDatetime)) {
            $this->endDatetime = $model->endDatetime;
            $this->showResults = true;
        }
        $displayMap = false;
        $displayEvent = false;
        $type = '';
        $modelClass = '';
        $sortField = 'productions';
        if ($model->scope == SearchForm::SCOPE_EVENT) {
            $type = Search::DOCUMENT_TYPE_EVENT;
            $displayEvent = true;
            $sortField = '';
        } elseif ($model->scope == SearchForm::SCOPE_CONTENT) {
            $type = Search::DOCUMENT_TYPE_CONTENT;
        } elseif ($model->scope == SearchForm::SCOPE_SPACE) {
            $modelClass = Space::class;
        } elseif ($model->scope == SearchForm::SCOPE_USER) {
            $modelClass = User::class;
        } elseif ($model->scope == SearchForm::SCOPE_CET_ENTITE) {
            $modelClass = Entite::class;
            $displayMap = true;
        } /*elseif ($model->scope == SearchForm::SCOPE_CET_PRODUIT) {
            $modelClass = CetProduit::class;
        } */ else {
            $model->scope = SearchForm::SCOPE_ALL;
        }
        if ($_SESSION['result'] == []) {
            //TODO : search result search load uniquement si !displaymap
            $options = [
                'model' => $modelClass,
                'type' => $type,
                'page' => 0,
                'sortField' => $sortField,
                'pageSize' => 40000,
                'limitSpaces' => $limitSpaces,
                'limitActivites' => $limitActivites,
                'limitCommunes' => $limitCommunes,
                'limitCategories' => $limitCategories,
                'limitTypes' => $limitTypes,
                'distanceRecherche' => $this->distanceRecherche,
                'isCertifier' => $this->isCertifier,
                'startDatetime' => $this->startDatetime,
                'displayEvent' => $displayEvent,
                'endDatetime' => $this->endDatetime,
            ];

            $searchResultSet = Yii::$app->search->find($model->keyword, $options);
            $total = $searchResultSet->total;
            // Store static for use in widgets (e.g. fileList)
            self::$keyword = $model->keyword;

            $pagination = new Pagination;
            $pagination->totalCount = $searchResultSet->total;
            $pagination->pageSize = Yii::$app->settings->get('paginationSize');
            $resulTotal = $searchResultSet->getResultInstances();
            $resultMap = [];
            if ($displayMap) {
                $resultMap = $resulTotal;
                /*$searchMapResultSet = $searchResultSet;
            $optionsMap = [
                'page' => 0,
                'sortField' => 'productions',
                'pageSize' => $searchMapResultSet->total,
                'limitSpaces' => $limitSpaces,
                'limitActivites' => $limitActivites,
                'limitCommunes' => $limitCommunes,
                'limitCategories' => $limitCategories,
                'limitTypes' => $limitTypes,
                'distanceRecherche' => $this->distanceRecherche,
                'isCertifier' => $this->isCertifier,
                'displayEvent' => false,
                'model' => $modelClass,
                'type' => $type,
            ];

            $searchMapResultSet =  Yii::$app->search->find($model->keyword, $optionsMap);
            $resultMap = $searchMapResultSet->getResultInstances();*/
            }
            $resulTotal = $searchResultSet->getResultInstances();
            $_SESSION['result'] = $resulTotal;
            //print(var_dump($model->result));
        } else {
            $resulTotal = $_SESSION['result'];
            $pagination = new Pagination;
            $pagination->totalCount = count($resulTotal);
            $total = count($resulTotal);
            $pagination->pageSize = Yii::$app->settings->get('paginationSize');
            self::$keyword = $model->keyword;
            $resultMap = [];
            if ($displayMap) {
                $resultMap = $resulTotal;
            }
        }
        $resultPaginate =  array_slice($resulTotal, ($model->page - 1) * Yii::$app->settings->get('paginationSize'), ($model->page) * Yii::$app->settings->get('paginationSize'));
        //print(var_dump($model));
        return $this->render('index', [
            'model' => $model,
            'results' => $resultPaginate,
            'resultMap' => $resultMap,
            'pagination' => $pagination,
            'total' => $total,
            'limitSpaces' => $limitSpaces,
            'limitActivites' => $limitActivites,
            'dataActivites' => $dataActivites,
            'valueActivites' => $valueActivites,
            'limitCategories' => $limitCategories,
            'dataCategories' => $dataCategories,
            'valueCategories' => $valueCategories,
            'limitTypes' => $limitTypes,
            'dataTypes' => $dataTypes,
            'valueTypes' => $valueTypes,
            'limitCommunes' => $limitCommunes,
            'distanceRecherche' => $this->distanceRecherche,
            'displayMap' => $displayMap,
            'displayEvent' => $displayEvent,
            'showResults' => $this->showResults,
            'isCertifier' => $this->isCertifier,
            'startDatetime' => $this->startDatetime,
            'endDatetime' => $this->endDatetime,
        ]);
    }
}
