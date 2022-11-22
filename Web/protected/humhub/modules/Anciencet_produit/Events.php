<?php

namespace humhub\modules\cet_produit;

use yii\base\BaseObject;
use Yii;
use humhub\modules\cet_produit\models\CetProduit;


class Events extends BaseObject
{
    public static function onSearchRebuild($event)
    {
        print 'onSearchRebuild cetProduit' . "\n";
        foreach (CetProduit::find()->each() as $cet_produit) {
            Yii::$app->search->add($cet_produit);
            print $cet_produit->nom . "added \n";
        }
    }

}
