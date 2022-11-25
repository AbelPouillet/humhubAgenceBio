<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Produitnaf $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produitnaf-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codenaf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'libelle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cet_produit_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
