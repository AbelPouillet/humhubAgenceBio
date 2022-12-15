<?php

namespace app\controllers;

use app\models\cetcal_model\Joinetatproductionproduction;
use app\models\search_model\JoinetatproductionproductionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JoinetatproductionproductionController implements the CRUD actions for Joinetatproductionproduction model.
 */
class JoinetatproductionproductionController extends Controller
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
     * Lists all Joinetatproductionproduction models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new JoinetatproductionproductionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Joinetatproductionproduction model.
     * @param int $cet_etat_production_id Cet Etat Production ID
     * @param int $cet_production_id Cet Production ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cet_etat_production_id, $cet_production_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cet_etat_production_id, $cet_production_id),
        ]);
    }

    /**
     * Creates a new Joinetatproductionproduction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Joinetatproductionproduction();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'cet_etat_production_id' => $model->cet_etat_production_id, 'cet_production_id' => $model->cet_production_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Joinetatproductionproduction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $cet_etat_production_id Cet Etat Production ID
     * @param int $cet_production_id Cet Production ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cet_etat_production_id, $cet_production_id)
    {
        $model = $this->findModel($cet_etat_production_id, $cet_production_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cet_etat_production_id' => $model->cet_etat_production_id, 'cet_production_id' => $model->cet_production_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Joinetatproductionproduction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $cet_etat_production_id Cet Etat Production ID
     * @param int $cet_production_id Cet Production ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cet_etat_production_id, $cet_production_id)
    {
        $this->findModel($cet_etat_production_id, $cet_production_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Joinetatproductionproduction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $cet_etat_production_id Cet Etat Production ID
     * @param int $cet_production_id Cet Production ID
     * @return Joinetatproductionproduction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cet_etat_production_id, $cet_production_id)
    {
        if (($model = Joinetatproductionproduction::findOne(['cet_etat_production_id' => $cet_etat_production_id, 'cet_production_id' => $cet_production_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
