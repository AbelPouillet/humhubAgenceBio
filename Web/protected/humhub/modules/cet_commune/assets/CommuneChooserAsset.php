<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\cet_commune\assets;

use humhub\components\assets\AssetBundle;
use humhub\modules\user\assets\UserAsset;

class CommuneChooserAsset extends AssetBundle
{
    public $sourcePath = '@cet_commune/resources';

    public $js = [
        'js/humhub.commune.chooser.js'
    ];

    public $depends = [
        CommuneAsset::class
    ];
}
