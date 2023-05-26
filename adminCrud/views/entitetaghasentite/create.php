<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\EntiteTagHasEntite $model */

$this->title = 'Create Entite Tag Has Entite';
$this->params['breadcrumbs'][] = ['label' => 'Entite Tag Has Entites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entite-tag-has-entite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
