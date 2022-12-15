<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinentitetype $model */

$this->title = 'Update Joinentitetype: ' . $model->cet_entite_id;
$this->params['breadcrumbs'][] = ['label' => 'Joinentitetypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_entite_id, 'url' => ['view', 'cet_entite_id' => $model->cet_entite_id, 'cet_type_id' => $model->cet_type_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="joinentitetype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
