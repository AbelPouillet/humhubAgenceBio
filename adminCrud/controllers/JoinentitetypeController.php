<?php

namespace app\controllers;

use app\models\cetcal_model\Joinentitetype;
use app\models\search_model\JoinentitetypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JoinentitetypeController implements the CRUD actions for Joinentitetype model.
 */
class JoinentitetypeController extends Controller
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
     * Lists all Joinentitetype models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new JoinentitetypeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Joinentitetype model.
     * @param int $cet_entite_id Cet Entite ID
     * @param int $cet_type_id Cet Type ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cet_entite_id, $cet_type_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cet_entite_id, $cet_type_id),
        ]);
    }

    /**
     * Creates a new Joinentitetype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Joinentitetype();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'cet_entite_id' => $model->cet_entite_id, 'cet_type_id' => $model->cet_type_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Joinentitetype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $cet_entite_id Cet Entite ID
     * @param int $cet_type_id Cet Type ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cet_entite_id, $cet_type_id)
    {
        $model = $this->findModel($cet_entite_id, $cet_type_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cet_entite_id' => $model->cet_entite_id, 'cet_type_id' => $model->cet_type_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Joinentitetype model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $cet_entite_id Cet Entite ID
     * @param int $cet_type_id Cet Type ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cet_entite_id, $cet_type_id)
    {
        $this->findModel($cet_entite_id, $cet_type_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Joinentitetype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $cet_entite_id Cet Entite ID
     * @param int $cet_type_id Cet Type ID
     * @return Joinentitetype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cet_entite_id, $cet_type_id)
    {
        if (($model = Joinentitetype::findOne(['cet_entite_id' => $cet_entite_id, 'cet_type_id' => $cet_type_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
