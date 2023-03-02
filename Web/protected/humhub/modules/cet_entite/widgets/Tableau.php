<?php

namespace humhub\modules\cet_entite\widgets;

use yii\base\Widget;

class Tableau extends Widget
{

    public $cet_entite;

    public function run()
    {
        return $this->render('entiteTableau', ['cet_entite' => $this->cet_entite]);
    }

}
