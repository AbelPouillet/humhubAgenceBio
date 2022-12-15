<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinentitetype $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="joinentitetype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cet_entite_id')->textInput() ?>

    <?= $form->field($model, 'cet_type_id')->textInput() ?>

    <?= $form->field($model, 'isDefault')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
