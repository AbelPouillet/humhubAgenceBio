<?php

/* @var $type \humhub\modules\cet_type\models\CetType */

use humhub\modules\cet_type\widgets\Image;
use humhub\libs\Helpers;
use yii\helpers\Html;
?>

<li<?= (!$visible) ? ' style="display:none"' : '' ?> data-type-chooser-item <?= $data ?> data-type-guid="<?= $type->id; ?>">
        <div class="media">
            <?= Image::widget([
                'type' => $type,
                'width' => 24,
                'htmlOptions' => [
                    'class' => 'pull-left',
            ]]);
            ?>
            <div class="media-body">
                <strong class="type-name"><?= Html::encode($type->type); ?> <?= Html::encode($type->sous_type)?></strong>
                <br>
            </div>
        </div>
</li>
