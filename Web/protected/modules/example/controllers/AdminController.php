<?php

namespace humhub\modules\example\controllers;

use humhub\modules\admin\components\Controller;

class AdminController extends Controller
{

    /**
     * Render admin only page
     *
     * @return string
     */
    public function actionIndex()
    {
        echo exec("php /app/Web/protected/yii cron/run");

        return $this->render('index', [
            'res' => false,
            'cpt' => false,
        ]);
    }

    public function actionImport($cpt) {
        $cpt ++;
        $res = "Action Import Activated";
        return $this->render('index', [
            'res' => $res,
            'cpt' => $cpt
        ]);
    }

}

