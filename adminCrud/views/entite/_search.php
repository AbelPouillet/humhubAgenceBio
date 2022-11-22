<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search_model\EntiteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entite-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'raisonSociale') ?>

    <?= $form->field($model, 'denominationcourante') ?>

    <?= $form->field($model, 'siret') ?>

    <?= $form->field($model, 'numeroBio') ?>

    <?php // echo $form->field($model, 'telephone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'codeNAF') ?>

    <?php // echo $form->field($model, 'gerant') ?>

    <?php // echo $form->field($model, 'dateMaj') ?>

    <?php // echo $form->field($model, 'telephoneCommerciale') ?>

    <?php // echo $form->field($model, 'reseau') ?>

    <?php // echo $form->field($model, 'mixite') ?>

    <?php // echo $form->field($model, 'provenance') ?>

    <?php // echo $form->field($model, 'isActive')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
