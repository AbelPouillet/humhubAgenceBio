<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search_model\CertificatSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="certificat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pk_cet_entite') ?>

    <?= $form->field($model, 'organisme') ?>

    <?= $form->field($model, 'etatCertification') ?>

    <?= $form->field($model, 'dateSuspension') ?>

    <?php // echo $form->field($model, 'dateArret') ?>

    <?php // echo $form->field($model, 'dateEngagement') ?>

    <?php // echo $form->field($model, 'dateNotification') ?>

    <?php // echo $form->field($model, 'url') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
