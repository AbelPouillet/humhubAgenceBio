<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joininfossupplementairesentite $model */

$this->title = 'Create Joininfossupplementairesentite';
$this->params['breadcrumbs'][] = ['label' => 'Joininfossupplementairesentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joininfossupplementairesentite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
