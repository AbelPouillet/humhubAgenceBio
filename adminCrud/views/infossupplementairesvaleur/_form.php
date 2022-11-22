<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\cetcal_model\Infossupplementairesvaleur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="infossupplementairesvaleur-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pk_cet_infos_supplementaires')->textInput() ?>

    <?= $form->field($model, 'valeur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cet_entite_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
