<?php

namespace app\controllers;

use app\models\cetcal_model\Produitnaf;
use app\models\search_model\ProduitnafSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProduitnafController implements the CRUD actions for Produitnaf model.
 */
class ProduitnafController extends Controller
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
     * Lists all Produitnaf models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProduitnafSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Produitnaf model.
     * @param int $cet_produit_id Cet Produit ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cet_produit_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cet_produit_id),
        ]);
    }

    /**
     * Creates a new Produitnaf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Produitnaf();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'cet_produit_id' => $model->cet_produit_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Produitnaf model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $cet_produit_id Cet Produit ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cet_produit_id)
    {
        $model = $this->findModel($cet_produit_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cet_produit_id' => $model->cet_produit_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Produitnaf model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $cet_produit_id Cet Produit ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cet_produit_id)
    {
        $this->findModel($cet_produit_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Produitnaf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $cet_produit_id Cet Produit ID
     * @return Produitnaf the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cet_produit_id)
    {
        if (($model = Produitnaf::findOne(['cet_produit_id' => $cet_produit_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
