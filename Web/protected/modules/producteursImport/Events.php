<?php

namespace  humhub\modules\producteursImport;

use Yii;
use yii\helpers\Url;

class Events
{
    /**
     * Defines what to do when the top menu is initialized.
     *
     * @param $event
     */
    public static function onTopMenuInit($event)
    {
        $event->sender->addItem([
            'label' => 'Import',
            'icon' => '<i class="fa fa-user"></i>',
            'url' => Url::to(['/producteursImport/index']),
            'sortOrder' => 99999,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'producteursImport'),
        ]);
    }

    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem([
            'label' => 'Import',
            'url' => Url::to(['/producteursImport/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-user"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'producteursImport' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 99999,
        ]);
    }
}
