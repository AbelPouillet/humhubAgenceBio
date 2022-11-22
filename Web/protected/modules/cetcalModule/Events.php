<?php

namespace  humhub\modules\cetcalModule;

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
            'label' => 'CetCal',
            'icon' => '<i class="fa fa-map-marker"></i>',
            'url' => Url::to(['/cetcalModule/index']),
            'sortOrder' => 99999,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'cetcalModule'),
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
            'label' => 'CetCal',
            'url' => Url::to(['/cetcalModule/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-map-marker"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'cetcalModule' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 99999,
        ]);
    }
}
