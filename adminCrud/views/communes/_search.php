<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search_model\CommunesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="communes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'libelle') ?>

    <?= $form->field($model, 'Latitude') ?>

    <?= $form->field($model, 'Longitude') ?>

    <?= $form->field($model, 'commune') ?>

    <?php // echo $form->field($model, 'code_postal') ?>

    <?php // echo $form->field($model, 'code_departement') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
