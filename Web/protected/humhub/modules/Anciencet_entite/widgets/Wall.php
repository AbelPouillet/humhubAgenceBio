<?php

namespace humhub\modules\cet_entite\widgets;

use yii\base\Widget;

class Wall extends Widget
{

    public $cet_entite;

    public function run()
    {
        return $this->render('cetEntiteWall', ['cet_entite' => $this->cet_entite]);
    }

}
