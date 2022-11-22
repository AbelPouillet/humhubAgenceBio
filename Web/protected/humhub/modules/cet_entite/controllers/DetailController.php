<?php

namespace humhub\modules\cet_entite\controllers;

use humhub\components\Controller;
use humhub\modules\cet_entite\models\Entite;

class DetailController extends Controller {

    public function actionIndex($id)
    {
        $cet_entite = Entite::find()->where(['id' => $id])->one();
        $this->pageTitle = "Detail";
        return $this->render('index', ['cet_entite' => $cet_entite]);
    }
}
