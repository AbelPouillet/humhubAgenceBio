<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\cet_type\assets;

use humhub\components\assets\AssetBundle;

class TypeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@cet_type/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/humhub.type.js'
    ];
}
