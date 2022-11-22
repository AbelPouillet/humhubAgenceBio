<?php

namespace humhub\modules\cet_commune\widgets;

use humhub\components\Widget;
use Yii;

/**
 * Used to render a single commune chooser result.
 *
 */
class CommuneChooserItem extends Widget
{


    public $commune;

    /**
     * @var integer
     */
    public $updateCount = 0;

    /**
     * @var boolean
     */
    public $visible = true;


    public function run()
    {


        return $this->render('communeChooserItem', [
            'commune' => $this->commune,
            'updateCount' => $this->updateCount,
            'visible' => $this->visible,

        ]);
    }
}
