<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Typeadresse $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="typeadresse-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pk_cet_adresse_operateur')->textInput() ?>

    <?= $form->field($model, 'nom')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
