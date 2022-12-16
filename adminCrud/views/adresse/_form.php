<?php


use app\models\cetcal_model\Typeadresse;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\cetcal_model\Adresse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adresse-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'lieu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codePostal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ville')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lat')->textInput() ?>

    <?= $form->field($model, 'long')->textInput() ?>

    <?= $form->field($model, 'codeCommune')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'departementId')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
