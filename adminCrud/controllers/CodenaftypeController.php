<?php

namespace app\controllers;

use app\models\cetcal_model\Codenaftype;
use app\models\search_model\CodenaftypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CodenaftypeController implements the CRUD actions for Codenaftype model.
 */
class CodenaftypeController extends Controller
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
     * Lists all Codenaftype models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CodenaftypeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Codenaftype model.
     * @param int $id ID
     * @param int $cet_type_id Cet Type ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $cet_type_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $cet_type_id),
        ]);
    }

    /**
     * Creates a new Codenaftype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Codenaftype();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'cet_type_id' => $model->cet_type_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Codenaftype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $cet_type_id Cet Type ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $cet_type_id)
    {
        $model = $this->findModel($id, $cet_type_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'cet_type_id' => $model->cet_type_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Codenaftype model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $cet_type_id Cet Type ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $cet_type_id)
    {
        $this->findModel($id, $cet_type_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Codenaftype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $cet_type_id Cet Type ID
     * @return Codenaftype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $cet_type_id)
    {
        if (($model = Codenaftype::findOne(['id' => $id, 'cet_type_id' => $cet_type_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
