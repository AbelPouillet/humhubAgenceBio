<?php

/* @var $commune \humhub\modules\cet_commune\models\CetCommune */

use humhub\modules\cet_commune\widgets\Image;
use humhub\libs\Helpers;
use yii\helpers\Html;
?>

<li<?= (!$visible) ? ' style="display:none"' : '' ?> data-commune-chooser-item <?= $data ?> data-commune-guid="<?= $commune->id; ?>">
        <div class="media">
            <?= Image::widget([
                'commune' => $commune,
                'width' => 24,
                'htmlOptions' => [
                    'class' => 'pull-left',
            ]]);
            ?>
            <div class="media-body">
                <strong class="commune-name"><?= Html::encode($commune->commune); ?></strong>
                <br>
            </div>
        </div>
</li>
