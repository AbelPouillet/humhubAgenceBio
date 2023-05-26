<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\EntiteTag $model */

$this->title = 'Create Entite Tag';
$this->params['breadcrumbs'][] = ['label' => 'Entite Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entite-tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
