<?php

namespace app\controllers;

use app\models\cetcal_model\Activite;
use app\models\cetcal_model\Adresse;
use app\models\cetcal_model\Certificat;
use app\models\cetcal_model\Entite;
use app\models\cetcal_model\Categorie;
use app\models\cetcal_model\Etatproduction;
use app\models\cetcal_model\Joinactiviteentite;
use app\models\cetcal_model\Joinadresseentite;
use app\models\cetcal_model\Joincategorieentite;
use app\models\cetcal_model\Joinetatproductionproduction;
use app\models\cetcal_model\Joinproductionentite;
use app\models\cetcal_model\Joinsitewebentite;
use app\models\cetcal_model\Jointypesitewebsiteweb;
use app\models\cetcal_model\Production;
use app\models\cetcal_model\Siteweb;
use app\models\cetcal_model\Typeadresse;
use app\models\cetcal_model\Type;
use app\models\cetcal_model\Typesiteweb;
use app\models\search_model\EntiteSearch;
use \ForceUTF8\Encoding;
use app\models\cetcal_model\Joinentitetype;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * EntiteController implements the CRUD actions for Entite model.
 */
class EntiteController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Entite models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EntiteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Entite model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Entite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Entite();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Entite model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Entite model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionLink()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '300');
        $error = "";
        foreach (Entite::find()->all() as $entite) {
            $defaultLink = new Joinentitetype();
            $defaultLink->isDefault = true;
            $defaultLink->cet_entite_id = $entite->id;
            $typeId = 0;
            $typenaf = "";

            foreach (Type::find()->all() as $type) {
                foreach ($type->cetCodeNafTypes as $codeNaf) {
                    if (
                        str_starts_with($entite->codeNAF, $codeNaf->codeNaf) &&
                        strlen($typenaf) < strlen($codeNaf->codeNaf)
                    ) {
                        //On cherche le type par défaut le plus précis possible
                        $typeId = $type->id;
                        $typenaf = $codeNaf->codeNaf;
                    }
                }
            }
            if ($typeId == 0) {
                $error .= "Pas de type pour le code " . $entite->codeNAF . " \n";
            } else {
                $defaultLink->cet_type_id = $typeId;
                $defaultLink->save();
            }

            foreach ($entite->productions as $production) {
                $codeHandled = false;
                foreach (Type::find()->all() as $type) {
                    $link = new Joinentitetype();
                    $link->isDefault = false;
                    $link->cet_entite_id = $entite->id;

                    foreach ($type->cetCodeNafTypes as $codeNaf) {
                        if (str_starts_with($production->code, $codeNaf->codeNaf)) {
                            $link->cet_type_id = $type->id;
                            $codeHandled = true;
                        }
                    }
                    if ($link->cet_type_id) {
                        $link->save();
                    }
                }
                if (!$codeHandled) {
                    $error .= " Pas de type pour le code " . $production->code . " \n";
                }
            }
        }
        return "linked " . $error;
    }
    public function actionLoad()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '300');
        $jsonTab = $this->curlPage(0, 0, []);
        if (isset($jsonTab)) {
            foreach ($jsonTab as $item) {
                $modelEntite = Entite::findOne(['id' => intVal($item['id'], 10)])
                    ? Entite::findOne(['id' => intVal($item['id'], 10)]) : new Entite();
                $modelEntite->id = intVal($item['id'], 10);
                if (isset($item['raisonSociale'])) $modelEntite->raisonSociale = Encoding::fixUTF8($item['raisonSociale'], Encoding::ICONV_TRANSLIT);
                if (isset($item['denominationcourante'])) $modelEntite->denominationcourante = Encoding::fixUTF8($item['denominationcourante'], Encoding::ICONV_TRANSLIT);
                if (isset($item['siret'])) $modelEntite->siret = $item['siret'];
                if (isset($item['numeroBio'])) $modelEntite->numeroBio = intVal($item['numeroBio'], 10);
                if (isset($item['telephone'])) $modelEntite->telephone = $item['telephone'];
                if (isset($item['email'])) $modelEntite->email = $item['email'];
                if (isset($item['codeNAF'])) $modelEntite->codeNAF = $item['codeNAF'];
                if (isset($item['gerant'])) $modelEntite->gerant = $item['gerant'];
                if (isset($item['dateMaj'])) $modelEntite->dateMaj = $item['dateMaj'];
                if (isset($item['telephoneCommerciale'])) $modelEntite->telephoneCommerciale = $item['telephoneCommerciale'];
                if (isset($item['reseau'])) $modelEntite->reseau = $item['reseau'];
                if (isset($item['mixite'])) $modelEntite->mixite = $item['mixite'];
                $modelEntite->provenance = 'API Agence Bio';
                $modelEntite->isActive = true;
                if ($modelEntite->save()) {
                    if (isset($item['categories'])) {
                        foreach ($item['categories'] as $categorie) {
                            $modelCategory = Categorie::findOne(['id' => intVal($categorie['id'], 10)])
                                ? Categorie::findOne(['id' => intVal($categorie['id'], 10)]) : new Categorie();
                            $modelCategory->id =  intVal($categorie['id'], 10);
                            $modelCategory->nom = $categorie['nom'];
                            if ($modelCategory->save()) {
                                $modelJoinCatEnt = Joincategorieentite::findOne(['cet_categorie_id' => intVal($categorie['id'], 10), 'cet_entite_id' => intVal($item['id'], 10)]) ?
                                    Joincategorieentite::findOne(['cet_categorie_id' => intVal($categorie['id'], 10), 'cet_entite_id' => intVal($item['id'], 10)]) : new Joincategorieentite;
                                $modelJoinCatEnt->cet_categorie_id = intVal($categorie['id'], 10);
                                $modelJoinCatEnt->cet_entite_id = intVal($item['id'], 10);
                                $modelJoinCatEnt->save();
                            } else {
                                return 'category fail';
                            }
                        }
                    }
                    if (isset($item['siteWebs'])) {
                        foreach ($item['siteWebs'] as $site) {
                            $modelSite = SiteWeb::findOne(['id' => intVal($site['id'], 10)])
                                ? Siteweb::findOne(['id' => intVal($site['id'], 10)]) : new SiteWeb();
                            $modelSite->id = intVal($site['id'], 10);
                            $modelSite->url = $site['url'];
                            $modelSite->active = $site['active'];
                            $modelSite->operateurId = $site['operateurId'];
                            $modelSite->typeSiteWebId = $site['typeSiteWebId'];
                            $modelSite->save();
                            if (isset($site['typeSiteWeb'])) {
                                if (!Typesiteweb::findOne(['id' => $site['typeSiteWebId']])) {
                                    $modelTypeSite = new Typesiteweb();
                                    if (isset($site['typeSiteWeb']['id'])) $modelTypeSite->id = $site['typeSiteWeb']['id'];
                                    if (isset($site['typeSiteWeb']['nom'])) $modelTypeSite->nom = $site['typeSiteWeb']['nom'];
                                    if (isset($site['typeSiteWeb']['status'])) $modelTypeSite->status = $site['typeSiteWeb']['status'];
                                    $modelTypeSite->save();
                                }
                            }

                            $modelJoinSiteTypeSite = Jointypesitewebsiteweb::findOne(['cet_type_site_web_id' => $site['typeSiteWeb']['id'], 'cet_site_web_id' => intVal($site['id'], 10)])
                                ? Jointypesitewebsiteweb::findOne(['cet_type_site_web_id' => $site['typeSiteWeb']['id'], 'cet_site_web_id' => intVal($site['id'], 10)]) : new Jointypesitewebsiteweb();
                            $modelJoinSiteTypeSite->cet_site_web_id = intVal($site['id'], 10);
                            if (isset($site['typeSiteWeb']['id'])) $modelJoinSiteTypeSite->cet_type_site_web_id = $site['typeSiteWeb']['id'];
                            $modelJoinSiteTypeSite->save();
                            $modelJoinSiteEntite = Joinsitewebentite::findOne(['cet_site_web_id' => $site['id'], 'cet_entite_id' => intVal($item['id'], 10)])
                                ? Joinsitewebentite::findOne(['cet_site_web_id' => $site['id'], 'cet_entite_id' => intVal($item['id'], 10)]) : new Joinsitewebentite();
                            $modelJoinSiteEntite->cet_site_web_id = intVal($site['id'], 10);
                            $modelJoinSiteEntite->cet_entite_id = intVal($item['id'], 10);
                            $modelJoinSiteEntite->save();
                        }
                    }
                    if (isset($item['adressesOperateurs'])) {
                        foreach ($item['adressesOperateurs'] as $adresse) {

                            $modelAdresse = Adresse::findOne(['id' => intVal($adresse['id'], 10)]) ?
                                Adresse::findOne(['id' => intVal($adresse['id'], 10)]) : new Adresse();
                            $modelAdresse->id = intVal($adresse['id'], 10);
                            $modelAdresse->lieu = Encoding::fixUTF8($adresse['lieu'], Encoding::ICONV_TRANSLIT);
                            $modelAdresse->codePostal = $adresse['codePostal'];
                            $modelAdresse->ville = Encoding::fixUTF8($adresse['ville'], Encoding::ICONV_TRANSLIT);

                            $modelAdresse->lat = floatval($adresse['lat']);
                            $modelAdresse->long = floatval($adresse['long']);
                            $modelAdresse->codeCommune = $adresse['codeCommune'];

                            $modelAdresse->active = $adresse['active'] == "true" ? true : false;
                            $modelAdresse->departementId = intVal($adresse['departementId'], 10);
                            if ($adresse['typeAdresseOperateurs']) {
                                foreach ($adresse['typeAdresseOperateurs'] as $typeAdresse) {
                                    $modelTypeAdresse = Typeadresse::findOne(['nom' => $typeAdresse, 'pk_cet_adresse_operateur' => intVal($adresse['id'], 10)])
                                        ? Typeadresse::findOne(['nom' => $typeAdresse, 'pk_cet_adresse_operateur' => intVal($adresse['id'], 10)]) : new Typeadresse();
                                    $modelTypeAdresse->nom = $typeAdresse;
                                    $modelTypeAdresse->pk_cet_adresse_operateur = intVal($adresse['id'], 10);
                                    $modelTypeAdresse->save();
                                }
                            }

                            if ($modelAdresse->save()) {
                                $modelJoinAdresseEntite = Joinadresseentite::findOne(['cet_adresse_operateur_id' => intVal($adresse['id'], 10), 'cet_entite_id' => intVal($item['id'], 10)])
                                    ? Joinadresseentite::findOne(['cet_adresse_operateur_id' => intVal($adresse['id'], 10), 'cet_entite_id' => intVal($item['id'], 10)]) : new Joinadresseentite;
                                $modelJoinAdresseEntite->cet_adresse_operateur_id = intVal($adresse['id'], 10);
                                $modelJoinAdresseEntite->cet_entite_id = intVal($item['id'], 10);
                                $modelJoinAdresseEntite->save();
                            } else {
                                return 'adresse fail';
                            }
                        }
                    }
                    if (isset($item['productions'])) {
                        foreach ($item['productions'] as $production) {
                            $modelProduction = Production::findOne(['id' => intVal($production['id'], 10)]) ?
                                Production::findOne(['id' => intVal($production['id'], 10)]) : new Production();
                            $modelProduction->id = intVal($production['id'], 10);
                            //TODO map code naf
                            $modelProduction->code = $this->mapCodeStr($production['code']);
                            $modelProduction->nom = $production['nom'];
                            if (isset($production['etatProductions'])) {
                                foreach ($production['etatProductions'] as $etatProduction) {
                                    $modelEtatProduction = EtatProduction::findOne(['id' => intVal($etatProduction['id'], 10)]) ?
                                        EtatProduction::findOne(['id' => intVal($etatProduction['id'], 10)]) : new Etatproduction();
                                    $modelEtatProduction->id = intVal($etatProduction['id'], 10);
                                    if (isset($etatProduction['etatProduction'])) $modelEtatProduction->etatProduction = $etatProduction['etatProduction'];
                                    $modelEtatProduction->save();
                                    $modelJoinProductionEtatProduction = Joinetatproductionproduction::findOne(['cet_etat_production_id' => intVal($etatProduction['id'], 10), 'cet_production_id' => intVal($production['id'], 10)])
                                        ? Joinetatproductionproduction::findOne(['cet_etat_production_id' => intVal($etatProduction['id'], 10), 'cet_production_id' => intVal($production['id'], 10)]) : new Joinetatproductionproduction();
                                    $modelJoinProductionEtatProduction->cet_etat_production_id = intVal($etatProduction['id'], 10);
                                    $modelJoinProductionEtatProduction->cet_production_id = intVal($production['id'], 10);
                                    $modelJoinProductionEtatProduction->save();
                                }
                            }
                            $modelProduction->save();
                            $modelJoinProductionEntite = Joinproductionentite::findOne(['cet_production_id' => intVal($production['id'], 10), 'cet_entite_id' => intVal($item['id'], 10)])
                                ? Joinproductionentite::findOne(['cet_production_id' => intVal($production['id'], 10), 'cet_entite_id' => intVal($item['id'], 10)]) : new Joinproductionentite();
                            $modelJoinProductionEntite->cet_production_id = intVal($production['id'], 10);
                            $modelJoinProductionEntite->cet_entite_id = intVal($item['id'], 10);
                            $modelJoinProductionEntite->save();
                        }
                    }
                    if (isset($item['activites'])) {
                        foreach ($item['activites'] as $activite) {
                            $modelActivite = Activite::findOne(['id' => intVal($activite['id'], 10)]) ?
                                Activite::findOne(['id' => intVal($activite['id'], 10)]) : new Activite();
                            $modelActivite->id = intVal($activite['id'], 10);
                            $modelActivite->nom = $activite['nom'];
                            $modelActivite->save();
                            $modelJoinActiviteEntite = Joinactiviteentite::findOne(['cet_activite_id' => intVal($activite['id'], 10), 'cet_entite_id' => intVal($item['id'], 10)])
                                ? Joinactiviteentite::findOne(['cet_activite_id' => intVal($activite['id'], 10), 'cet_entite_id' => intVal($item['id'], 10)]) : new Joinactiviteentite();
                            $modelJoinActiviteEntite->cet_activite_id = intVal($activite['id'], 10);
                            $modelJoinActiviteEntite->cet_entite_id = intVal($item['id'], 10);
                            $modelJoinActiviteEntite->save();
                        }
                    }
                    if (isset($item['certificats'])) {
                        foreach ($item['certificats'] as $certificat) {
                            $modelCertificat = Certificat::find()->where(['url' => $certificat['url']])->one() ?
                                Certificat::find()->where(['url' => $certificat['url']])->one() : new Certificat();
                            if (isset($certificat['organisme'])) $modelCertificat->organisme = $certificat['organisme'];
                            if (isset($certificat['etatCertification'])) $modelCertificat->etatCertification = $certificat['etatCertification'];
                            if (isset($certificat['dateSuspension'])) $modelCertificat->dateSuspension = $certificat['dateSuspension'];
                            if (isset($certificat['dateArret'])) $modelCertificat->dateArret = $certificat['dateArret'];
                            if (isset($certificat['dateEngagement'])) $modelCertificat->dateEngagement = $certificat['dateEngagement'];
                            if (isset($certificat['dateNotification'])) $modelCertificat->dateNotification = $certificat['dateNotification'];
                            if (isset($certificat['url'])) $modelCertificat->url = $certificat['url'];
                            $modelCertificat->pk_cet_entite = intVal($item['id'], 10);
                            $modelCertificat->save();
                        }
                    }

                    $modelEntite->save();
                } else {
                    return 'entite failed to load' . var_dump($modelEntite);
                }
            }
        }

        return count($jsonTab) . ' entries loaded successfully';
        //return $this->redirect(['index']);
    }
    /**
     * Finds the Entite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Entite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Entite::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function mapCodeStr($code)
    {
        if (str_starts_with($code, "GP")) {
            switch ($code) {
                case 'GP.Viticulture.SGP.Viticulture':
                    return "01.21";
                case 'GP.Viticulture':
                    return "01.21";
                case 'GP.Stockage':
                    return "52.10";
                case 'GP.Services.et.traitements.primaires':
                    return $code;
                case 'GP.Semences.et.plants.SGP.Plants':
                    return "01.3";
                case 'GP.Semences.et.plants.SGP.Semences.fruitières':
                    return "01.3";
                case 'GP.Semences.et.plants.SGP.Autres.semences':
                    return '01.3';
                case "GP.Semences.et.plants.SGP.Semences.et.plants.potagers":
                    return "01.3";
                case 'GP.Semences.et.plants':
                    return "01.3";
                case 'GP.Restauration':
                    return "56";
                case 'GP.Produits.laitiers.SGP.Glaces.et.sorbets':
                    return "10.52";
                case "GP.Produits.d'épicerie":
                    return "47";
                case "GP.Préparations.à.base.de.fruits.et.légumes":
                    return "10.3";
                case "GP.Plantes.à.parfums,.aromatiques.et.médicinales.et.plantes.à.boissons.SGP.Plantes.à.parfum.et.médicinales":
                    return "01.28";
                case "GP.Plantes.à.parfums,.aromatiques.et.médicinales.et.plantes.à.boissons.SGP.Épices.et.herbes.fraîches":
                    return "01.28";
                case "GP.Plantes.à.parfums,.aromatiques.et.médicinales.et.plantes.à.boissons":
                    return "01.27";
                case "GP.Ovins.SGP.Ovins.Viande":
                    return "01.45";
                case "GP.Légumes.SGP.Légumes.à.racine,.à.bulbe.ou.à.tubercules":
                    return "01.13";
                case "GP.Légumes.SGP.Légumes.à.fruits":
                    return "01.13";
                case "GP.Légumes.SGP.Légumes.à.feuilles.ou.tiges":
                    return "01.13";
                case "GP.Légumes":
                    return "01.13";
                case "GP.Légumes.SGP.Autres.légumes.frais.et.maraîchage":
                    return "01.13";
                case "GP.Grandes.Cultures.SGP.Céréales":
                    return "01.11";
                case "GP.Grandes.Cultures":
                    return "01.1";
                case "GP.Fruits":
                    return "01.24";
                case "GP.Fruits.SGP.Fruits.tropicaux.et.subtropicaux":
                    return "01.22";
                case "GP.Fruits.SGP.Fruits.à.pépins.et.à.noyaux":
                    return "01.24";
                case "GP.Fruits.SGP.Baies":
                    return "01.25";
                case "GP.Fruits.SGP.Autres.fruits.frais":
                    return "01.25";
                case "GP.Fruits.SGP.Agrumes":
                    return "01.23";
                case "GP.Bois.et.cueillette.sauvage.SGP.Produits.sylvicoles":
                    return "02";
                case "GP.Autres.productions.végétales.SGP.Fleurs":
                    return "01.29";
                case "GP.Compléments.alimentaires":
                    return "10.89";
                case "GP.Commerce.de.gros":
                    return "46";
                case "GP.Commerce.de.détail":
                    return "47";
                case "GP.Bovins.SGP.Bovins.viande":
                    return "01.42";
                case "GP.Boulangerie-pâtisserie.et.pâtes.alimentaires":
                    return "10.7";
                case "GP.Boissons.(hors.jus)":
                    return "11";
                case "GP.Autres.produits.transformés":
                    return "10.39";
                case "GP.Aquaculture.et.récolte.de.sel":
                    return "03.2";
            }
        }
        return $code;
    }
    protected function curlPage($page, $distanceScan, $resultTab)
    {
        $curl = curl_init("https://opendata.agencebio.org/api/gouv/operateurs/?lng=-0.2443409&lat=44.914585&trierPar=coords&nb=420&debut=" . $page * 420);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($curl), true);
        foreach ($result['items'] as $item) {
            $distanceMin = 40;
            foreach ($item['adressesOperateurs'] as $address) {
                $distanceAdresse = $this->distance(44.914585, -0.2443409, $address['lat'], $address['long']);
                if ($distanceMin > $distanceAdresse) {
                    $distanceMin = $distanceAdresse;
                }
            }
            $distanceScan = $distanceMin;
            if ($distanceScan < 40) {
                $resultTab[] = $item;
            } else {
                return $resultTab;
            }
        }
        if ($distanceScan < 40) {
            return $this->curlPage($page + 1, $distanceScan, $resultTab);
        }
    }

    protected function distance($lat1, $lng1, $lat2, $lng2)
    {
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

        return  $km;
    }
}
