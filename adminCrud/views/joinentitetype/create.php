<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinentitetype $model */

$this->title = 'Create Joinentitetype';
$this->params['breadcrumbs'][] = ['label' => 'Joinentitetypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joinentitetype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
