<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\cetcal_model\Entite */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entite-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'raisonSociale')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'denominationcourante')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'siret')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numeroBio')->textInput() ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codeNAF')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gerant')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dateMaj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telephoneCommerciale')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reseau')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mixite')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'provenance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isActive')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
