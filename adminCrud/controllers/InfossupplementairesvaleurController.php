<?php

namespace app\controllers;

use app\models\cetcal_model\Infossupplementairesvaleur;
use app\models\search_model\InfossupplementairesvaleurSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InfossupplementairesvaleurController implements the CRUD actions for Infossupplementairesvaleur model.
 */
class InfossupplementairesvaleurController extends Controller
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
     * Lists all Infossupplementairesvaleur models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new InfossupplementairesvaleurSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Infossupplementairesvaleur model.
     * @param int $cet_entite_id Cet Entite ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cet_entite_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cet_entite_id),
        ]);
    }

    /**
     * Creates a new Infossupplementairesvaleur model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Infossupplementairesvaleur();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'cet_entite_id' => $model->cet_entite_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Infossupplementairesvaleur model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $cet_entite_id Cet Entite ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cet_entite_id)
    {
        $model = $this->findModel($cet_entite_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cet_entite_id' => $model->cet_entite_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Infossupplementairesvaleur model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $cet_entite_id Cet Entite ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cet_entite_id)
    {
        $this->findModel($cet_entite_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Infossupplementairesvaleur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $cet_entite_id Cet Entite ID
     * @return Infossupplementairesvaleur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cet_entite_id)
    {
        if (($model = Infossupplementairesvaleur::findOne(['cet_entite_id' => $cet_entite_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
