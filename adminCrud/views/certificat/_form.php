<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Certificat $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="certificat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pk_cet_entite')->textInput() ?>

    <?= $form->field($model, 'organisme')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'etatCertification')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dateSuspension')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dateArret')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dateEngagement')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dateNotification')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
