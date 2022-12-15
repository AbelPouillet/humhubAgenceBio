<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinetatproductionproduction $model */

$this->title = 'Update Joinetatproductionproduction: ' . $model->cet_etat_production_id;
$this->params['breadcrumbs'][] = ['label' => 'Joinetatproductionproductions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_etat_production_id, 'url' => ['view', 'cet_etat_production_id' => $model->cet_etat_production_id, 'cet_production_id' => $model->cet_production_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="joinetatproductionproduction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
