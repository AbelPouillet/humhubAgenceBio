<?php

namespace  humhub\modules\example;

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
            'label' => 'Run Cron',
            'icon' => '<i class="fa fa-bug"></i>',
            'url' => Url::to(['/example/index']),
            'sortOrder' => 99999,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'example' && Yii::$app->controller->id == 'index'),
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
            'label' => 'Run Cron',
            'url' => Url::to(['/example/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-bug"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'example' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 99999,
        ]);
    }
}
