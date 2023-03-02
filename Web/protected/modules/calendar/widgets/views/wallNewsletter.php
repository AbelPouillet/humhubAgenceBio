<?php

use yii\helpers\Html;
?>
<div>
    <h1 class="nomEvenement"><?= Html::encode($calendar_entry->title); ?></h1>
    <p class="descriptionEvenement"><?= Html::encode($calendar_entry->description) ?></p>
    <p class="tempsEvenement"><?= Html::encode($calendar_entry->getFormattedTime()) ?></p>
</div>
