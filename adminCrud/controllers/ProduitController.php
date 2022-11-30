<?php

namespace app\controllers;

use app\models\cetcal_model\Produit;
use app\models\cetcal_model\Produitnaf;
use app\models\search_model\ProduitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProduitController implements the CRUD actions for Produit model.
 */
class ProduitController extends Controller
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
    public function actionLoad()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '300');
        foreach (Produit::find()->all() as $produit) {
            $res =  $this->getNaf($produit->nom);
            $categorieNaf = [];
            switch ($produit->categorie) {
                case 'légume':
                    $categorieNaf = ['01', '10', '46', '47'];
                    break;

                case 'fruit':
                    $categorieNaf = ['01', '10', '46', '47'];
                    break;

                case 'viande':
                    $categorieNaf = ['01', '46', '47'];
                    break;

                case 'boisson':
                    $categorieNaf = ['10', '11', '46', '47'];
                    break;
                case 'céréales et dérivés/légumineuses':
                    $categorieNaf = ['01', '10', '46', '47'];
                    break;
                case 'champignon':
                    $categorieNaf = ['01', '02', '46', '47'];
                    break;
                case 'nourriture pour animaux':
                    $categorieNaf = ['10', '46', '47'];
                    break;
                case 'plante':
                    $categorieNaf = ['01', '10', '46', '47'];
                    break;
                case 'plants et semences':
                    $categorieNaf = ['01', '46', '47'];
                    break;
                case 'poissons ou coquillages':
                    $categorieNaf = ['03', '10', '46', '47'];
                    break;
                case 'produit de la ruche':
                    $categorieNaf = ['01', '10', '46', '47'];
                    break;
                case 'produit laitier':
                    $categorieNaf = ['01', '10', '46', '47'];
                    break;
                case "produits d'entretien":
                    $categorieNaf = ['20', '46', '47'];
                    break;
                case "produits d'hygiène":
                    $categorieNaf = ['20', '46', '47'];
                    break;
                case "produits transformés":
                    $categorieNaf = ['10', '46', '47'];
                    break;
                default:
                    $categorieNaf = ['01', '46', '47'];
                    break;
            }
            //print(var_dump($res));
            foreach ($res['documents'] as $doc) {
                //TODO filtre $categorieNaf sur isProduction foreach
                foreach ($categorieNaf as $nafniv1) {
                    if (str_starts_with($doc['code'], $nafniv1)) {
                        $produitnaf = new Produitnaf();
                        $produitnaf->cet_produit_id = $produit->id;
                        $produitnaf->libelle = $doc['libelle'];
                        $produitnaf->codenaf = $doc['code'];
                        $produitnaf->save();
                    }
                }
            }
        }
        return 'loaded';
    }

    public function getNaf($produit)
    {
        $data = array("q" => $produit, "start" => 0, "rows" => 100, "facetsQuery" => [], "filters" => []);
        //print(var_dump($data));
        $curl = curl_init('https://www.insee.fr/fr/metadonnees/nafr2/consultation');
        $payload = json_encode($data);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


        $response = json_decode(curl_exec($curl), true);
        //print(var_dump($response));
        curl_close($curl);
        return $response;
    }
    /**
     * Lists all Produit models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProduitSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Produit model.
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
     * Creates a new Produit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Produit();

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
     * Updates an existing Produit model.
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
     * Deletes an existing Produit model.
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

    /**
     * Finds the Produit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Produit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produit::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
