<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinactiviteentite $model */

$this->title = 'Update Joinactiviteentite: ' . $model->cet_activite_id;
$this->params['breadcrumbs'][] = ['label' => 'Joinactiviteentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_activite_id, 'url' => ['view', 'cet_activite_id' => $model->cet_activite_id, 'cet_entite_id' => $model->cet_entite_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="joinactiviteentite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
