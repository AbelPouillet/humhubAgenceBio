<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Codenaftype $model */

$this->title = 'Update Codenaftype: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Codenaftypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'cet_type_id' => $model->cet_type_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="codenaftype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
