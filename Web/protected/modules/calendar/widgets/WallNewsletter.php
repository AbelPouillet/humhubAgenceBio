<?php

namespace humhub\modules\calendar\widgets;
use yii\base\Widget;

class WallNewsletter extends Widget
{

    public $calendar_entry;

    public function run()
    {
        return $this->render('wallNewsletter', ['calendar_entry' => $this->calendar_entry]);
    }

}
