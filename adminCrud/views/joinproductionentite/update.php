<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinproductionentite $model */

$this->title = 'Update Joinproductionentite: ' . $model->cet_production_id;
$this->params['breadcrumbs'][] = ['label' => 'Joinproductionentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_production_id, 'url' => ['view', 'cet_production_id' => $model->cet_production_id, 'cet_entite_id' => $model->cet_entite_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="joinproductionentite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
