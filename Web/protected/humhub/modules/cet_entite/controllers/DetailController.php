<?php

namespace humhub\modules\cet_entite\controllers;

use humhub\components\Controller;
use humhub\modules\cet_entite\models\AdminForm;
use humhub\modules\cet_entite\models\Entite;
use Yii;

class DetailController extends Controller
{

    public function actionIndex($id)
    {
        $cet_entite = Entite::find()->where(['id' => $id])->one();
        $adminForm = new AdminForm();
        $adminForm->entiteId = intval($id, 10);
        $adminForm->initAdminForm();
        $this->pageTitle = "Detail";
        return $this->render('index', ['cet_entite' => $cet_entite, 'adminForm' => $adminForm]);
    }
    public function actionAdminpost($id)
    {
        $adminForm = new AdminForm();
        $adminForm->entiteId = intval($id, 10);
        $adminForm->initAdminForm();
        $adminForm->setAdresse(Yii::$app->request->post("AdminForm")["adresse"]);
        $adminForm->setEmail(Yii::$app->request->post("AdminForm")["email"]);
        $adminForm->setNomDusage(Yii::$app->request->post("AdminForm")["nomDusage"]);
        $adminForm->setSiteweb(Yii::$app->request->post("AdminForm")["siteweb"]);
        $adminForm->setTelephone(Yii::$app->request->post("AdminForm")["telephone"]);
        $this->redirect(['index', 'id' => $id]);
    }
}
