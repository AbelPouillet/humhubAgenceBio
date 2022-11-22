<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\cet_commune\assets;

use humhub\components\assets\AssetBundle;

class CommuneAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@cet_commune/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/humhub.commune.js'
    ];
}
