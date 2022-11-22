<?php

namespace humhub\modules\cet_type\widgets;

use humhub\components\Widget;
use Yii;

/**
 * Used to render a single type chooser result.
 *
 */
class TypeChooserItem extends Widget
{


    public $type;

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


        return $this->render('typeChooserItem', [
            'type' => $this->type,
            'updateCount' => $this->updateCount,
            'visible' => $this->visible,

        ]);
    }
}
