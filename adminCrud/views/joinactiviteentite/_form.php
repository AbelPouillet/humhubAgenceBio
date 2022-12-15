<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinactiviteentite $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="joinactiviteentite-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cet_activite_id')->textInput() ?>

    <?= $form->field($model, 'cet_entite_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
