<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\cet_type\assets;

use humhub\components\assets\AssetBundle;
use humhub\modules\user\assets\UserAsset;

class TypeChooserAsset extends AssetBundle
{
    public $sourcePath = '@cet_type/resources';

    public $js = [
        'js/humhub.type.chooser.js'
    ];

    public $depends = [
        TypeAsset::class
    ];
}
