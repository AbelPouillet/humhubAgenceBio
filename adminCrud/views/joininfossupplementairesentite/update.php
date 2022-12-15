<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joininfossupplementairesentite $model */

$this->title = 'Update Joininfossupplementairesentite: ' . $model->cet_infos_supplementaires_id;
$this->params['breadcrumbs'][] = ['label' => 'Joininfossupplementairesentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_infos_supplementaires_id, 'url' => ['view', 'cet_infos_supplementaires_id' => $model->cet_infos_supplementaires_id, 'cet_entite_id' => $model->cet_entite_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="joininfossupplementairesentite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
