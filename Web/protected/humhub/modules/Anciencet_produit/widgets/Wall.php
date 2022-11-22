<?php

namespace humhub\modules\cet_produit\widgets;

use yii\base\Widget;

class Wall extends Widget
{

    public $cet_produit;

    public function run()
    {
        return $this->render('cetProduitWall', ['cet_produit' => $this->cet_produit]);
    }

}
