<?php

/**
 * AdresseCet Location Map
 *
 * @package humhub.modules.adresseCetmap
 * @author KeudellCoding
 */

namespace humhub\modules\cetcalModule\widgets;

use Yii;
use yii\helpers\Url;
use humhub\components\Widget;
use humhub\modules\cetcalModule\models\admin\EditForm;
use humhub\modules\cet_entite\models\Entite;
use humhub\modules\cet_commune\models\CetCommune;

class MapView extends Widget
{

    public $cetEntites = [];
    /**
     * Height of the Widget (css Values)
     *
     * @var string
     */
    public $height = "40em";

    /**
     * Show map as panel
     *
     * @var bool
     */
    public $showAsPanel = false;

    /**
     * Link that is navigated to when the map is clicked.
     *
     * @var string
     */
    public $link = null;

    public $communes = [];

    public $distance = 10;

    public $userlat = null;

    public $userlong = null;

    public function run()
    {
        $settings = Yii::$app->getModule('cetcalModule')->settings;

        return $this->render(
            'mapView',
            [
                'height' => $this->height,
                'adresseCet_data' => $this->getAllAdresseCets(),
                'link' => $this->link,
                'showAsPanel' => $this->showAsPanel,
                'osmTileServer' => $settings->get('osm_tile_server', EditForm::DEFAULT_TILE_SERVER),
                'mapCenter' => [
                    'latitude' => $settings->get('osm_map_center_latitude', 44.9125685),
                    'longitude' => $settings->get('osm_map_center_longitude', -0.2443409),
                    'zoom' => $settings->get('osm_map_center_zoom', 5),
                ],
                'apikey' => $settings->get('geocoding_api_key', 'pk.eyJ1IjoiZGVjaWRlbGFiaW9sb2NhbGUiLCJhIjoiY2t4c3J1b3pmMTV4cDJzbXZ6aWtxOTNrbiJ9.UrHhSVL477MEsqwLPJubrQ'),
                'communesLatLng' => $this->getCoordinates(),
                'distance' => $this->distance,
                'userlat' => $this->userlat ? $this->userlat : "false",
                'userlong' => $this->userlong ? $this->userlong : "false",
            ]
        );
    }

    private function getAllAdresseCets()
    {
        if (count($this->cetEntites) > 0) {
            $formatedAdresseCets = [];
            foreach ($this->cetEntites as $cetEntite) {
                $defaultIcon = 'magasin';
                foreach ($cetEntite->activites as $activite) {
                    if ($activite->id == 1) {
                        $defaultIcon = 'ferme';
                    }
                }
                if (isset($cetEntite->cetTypes[0]) && $cetEntite->cetTypes[0]->id == 22) {
                    $defaultIcon = 'marché';
                }
                if ( isset($cetEntite->cetTypes[0]) && $cetEntite->cetTypes[0]->id == 23) {
                    $defaultIcon = 'AMAP';
                }
                if ( isset($cetEntite->cetTypes[0]) && $cetEntite->cetTypes[0]->id == 24) {
                    $defaultIcon = 'Asso';
                }
                if ( isset($cetEntite->cetTypes[0]) && $cetEntite->cetTypes[0]->id == 26) {
                    $defaultIcon = 'AssoDist';
                }
                foreach ($cetEntite->adresses as $adresseCet) {
                    isset($cetEntite->denominationcourante) ? $name = $cetEntite->denominationcourante : $name = $cetEntite->raisonSociale;
                    $formatedAdresseCets[] = [
                        'name' => $name,
                        'type' => $adresseCet->getTypeadressesSTR(),
                        'codeNAF' => $cetEntite->codeNAF,
                        'street' => $adresseCet->lieu,
                        'zip' => $adresseCet->codePostal,
                        'city' => $adresseCet->ville,
                        'defaultIcon' => $defaultIcon,
                        'latitude' => floatval($adresseCet->lat),
                        'longitude' => floatval($adresseCet->long),
                        'id' => $cetEntite->id
                    ];
                }
            }
            return $formatedAdresseCets;
        }
        $formatedAdresseCets = [];
        foreach (Entite::findAll(['isActive' => 1]) as $entiteCet) {
            $defaultIcon = 'magasin';
            foreach ($entiteCet->activites as $activite) {
                if ($activite->id == 1) {
                    $defaultIcon = 'ferme';
                }
            }
            if (isset($entiteCet->cetTypes[0]) && $entiteCet->cetTypes[0]->id == 22) {
                $defaultIcon = 'marché';
            }
            if (isset($entiteCet->cetTypes[0]) && $entiteCet->cetTypes[0]->id == 23) {
                $defaultIcon = 'AMAP';
            }
            if (isset($entiteCet->cetTypes[0]) && $entiteCet->cetTypes[0]->id == 24) {
                $defaultIcon = 'Asso';
            }
            if (isset($entiteCet->cetTypes[0]) && $entiteCet->cetTypes[0]->id == 26) {
                $defaultIcon = 'AssoDist';
            }
            foreach ($entiteCet->adresses as $adresseCet) {
                isset($entiteCet->denominationcourante) ? $name = $entiteCet->denominationcourante : $name = $entiteCet->raisonSociale;
                $formatedAdresseCets[] = [
                    'name' => $name,
                    'type' => $adresseCet->getTypeadressesSTR(),
                    'codeNAF' => $entiteCet->codeNAF,
                    'street' => $adresseCet->lieu,
                    'zip' => $adresseCet->codePostal,
                    'city' => $adresseCet->ville,
                    'latitude' => floatval($adresseCet->lat),
                    'longitude' => floatval($adresseCet->long),
                    'defaultIcon' => $defaultIcon,
                    'id' => $entiteCet->id
                ];
            }
        }
        return $formatedAdresseCets;
    }

    private function getCoordinates()
    {
        $communesLatLng = [];
        foreach ($this->communes as $commune) {
            $coordinates = [];
            if ($commune->Latitude !== null && $commune->Longitude !== null) {
                $coordinates = [
                    'latitude' => $commune->Latitude,
                    'longitude' => $commune->Longitude
                ];
                $communesLatLng[] = $coordinates;
            }
        }
        return $communesLatLng;
    }
}
