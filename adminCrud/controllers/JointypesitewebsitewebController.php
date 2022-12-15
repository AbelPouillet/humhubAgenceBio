<?php

namespace app\controllers;

use app\models\cetcal_model\Jointypesitewebsiteweb;
use app\models\search_model\JointypesitewebsitewebSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JointypesitewebsitewebController implements the CRUD actions for Jointypesitewebsiteweb model.
 */
class JointypesitewebsitewebController extends Controller
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
     * Lists all Jointypesitewebsiteweb models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new JointypesitewebsitewebSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jointypesitewebsiteweb model.
     * @param int $cet_type_site_web_id Cet Type Site Web ID
     * @param int $cet_site_web_id Cet Site Web ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cet_type_site_web_id, $cet_site_web_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cet_type_site_web_id, $cet_site_web_id),
        ]);
    }

    /**
     * Creates a new Jointypesitewebsiteweb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Jointypesitewebsiteweb();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'cet_type_site_web_id' => $model->cet_type_site_web_id, 'cet_site_web_id' => $model->cet_site_web_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Jointypesitewebsiteweb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $cet_type_site_web_id Cet Type Site Web ID
     * @param int $cet_site_web_id Cet Site Web ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cet_type_site_web_id, $cet_site_web_id)
    {
        $model = $this->findModel($cet_type_site_web_id, $cet_site_web_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cet_type_site_web_id' => $model->cet_type_site_web_id, 'cet_site_web_id' => $model->cet_site_web_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Jointypesitewebsiteweb model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $cet_type_site_web_id Cet Type Site Web ID
     * @param int $cet_site_web_id Cet Site Web ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cet_type_site_web_id, $cet_site_web_id)
    {
        $this->findModel($cet_type_site_web_id, $cet_site_web_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Jointypesitewebsiteweb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $cet_type_site_web_id Cet Type Site Web ID
     * @param int $cet_site_web_id Cet Site Web ID
     * @return Jointypesitewebsiteweb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cet_type_site_web_id, $cet_site_web_id)
    {
        if (($model = Jointypesitewebsiteweb::findOne(['cet_type_site_web_id' => $cet_type_site_web_id, 'cet_site_web_id' => $cet_site_web_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
