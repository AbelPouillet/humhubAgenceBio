<?php

namespace humhub\modules\cet_entite\controllers;

use humhub\components\Controller;
use humhub\modules\cet_entite\models\AdminForm;
use humhub\modules\cet_entite\models\Entite;
use humhub\modules\cet_infos_supplementaires\models\Infossupplementaires;
use humhub\modules\cet_infos_supplementaires_valeur\models\Infossupplementairesvaleur;
use humhub\modules\cet_join_infos_supplementaires_entite\models\Joininfossupplementairesentite;
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
        $infossupptab = [];
        $jointab = Joininfossupplementairesentite::find()->where(['cet_entite_id' => $id])->all();
        foreach($jointab as $join){
            $infosupp = Infossupplementaires::findOne(["id" => $join->cet_infos_supplementaires_id]);
            $label = $infosupp->label;
            $infosuppval = Infossupplementairesvaleur::findOne(["pk_cet_infos_supplementaires" => $join->cet_infos_supplementaires_id , "cet_entite_id" => $id]);
            $valeur = $infosuppval->valeur;
            $infossupptab[$label]= $valeur;
        }
        return $this->render('index', ['cet_entite' => $cet_entite, 'adminForm' => $adminForm, 'infossupp' => $infossupptab]);
    }
    public function actionAdminpost($id)
    {
        $adminForm = new AdminForm();
        $adminForm->entiteId = intval($id, 10);
        $cet_entite = Entite::findOne(['id' => intval($id, 10)]);
        $adminForm->initAdminForm();
        $adminForm->setAdresse(Yii::$app->request->post("AdminForm")["adresse"]);
        $adminForm->setEmail(Yii::$app->request->post("AdminForm")["email"]);
        $adminForm->setNomDusage(Yii::$app->request->post("AdminForm")["nomDusage"]);
        $adminForm->setSiteweb(Yii::$app->request->post("AdminForm")["siteweb"]);
        $adminForm->setTelephone(Yii::$app->request->post("AdminForm")["telephone"]);
        $adminForm->setTags(Yii::$app->request->post("AdminForm")["tags"]);
        Yii::$app->search->update($cet_entite);
        $this->redirect(['index', 'id' => $id]);
    }
}
