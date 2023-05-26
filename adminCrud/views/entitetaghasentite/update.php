<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\EntiteTagHasEntite $model */

$this->title = 'Update Entite Tag Has Entite: ' . $model->cet_entite_tag_id;
$this->params['breadcrumbs'][] = ['label' => 'Entite Tag Has Entites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_entite_tag_id, 'url' => ['view', 'cet_entite_tag_id' => $model->cet_entite_tag_id, 'cet_entite_id' => $model->cet_entite_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="entite-tag-has-entite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
