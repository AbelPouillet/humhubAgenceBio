<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\cetcal_model\Communes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="communes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'libelle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Latitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Longitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commune')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code_postal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code_departement')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
