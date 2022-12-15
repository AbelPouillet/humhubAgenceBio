<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinproductionentite $model */

$this->title = 'Create Joinproductionentite';
$this->params['breadcrumbs'][] = ['label' => 'Joinproductionentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joinproductionentite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
