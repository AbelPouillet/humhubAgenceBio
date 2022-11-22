<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\popovervcard\assets;

use humhub\modules\ui\view\components\View;
use yii\helpers\Url;
use yii\web\AssetBundle;

class Assets extends AssetBundle
{

    public $publishOptions = [
        'forceCopy' => false
    ];
    public $sourcePath = '@popover-vcard/resources';
    public $css = [
        'humhub.vcard.popover.css'
    ];
    public $js = [
        'humhub.vcard.popover.js'
    ];

    /**
     * @param View $view
     * @return void|AssetBundle
     */
    public static function register($view)
    {
        parent::register($view);

        $view->registerJsConfig('vcard.popover', [
            'delay' => 500,
            'loadUrl' =>  Url::to(['/popover-vcard/index/load'])
        ]);
    }

}
