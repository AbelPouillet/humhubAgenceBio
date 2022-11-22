<?php

namespace humhub\modules\cet_entite;

use yii\base\BaseObject;
use Yii;
use humhub\modules\cet_entite\models\CetEntite;
use humhub\components\Event;


class Events extends BaseObject
{
    /**
     * On rebuild of the search index, rebuild all cet entite records
     *
     * @param Event $event
     */
    public static function onSearchRebuild($event)
    {
        print 'onSearchRebuild cet entite' . "\n";
        foreach (CetEntite::find()->each() as $cet_entite) {
            print $cet_entite->name . " try to add \n";
            Yii::$app->search->add($cet_entite);
            print $cet_entite->name . "added \n";
        }
        print "cet entite loaded \n";
    }

}
