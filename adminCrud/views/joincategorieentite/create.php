<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joincategorieentite $model */

$this->title = 'Create Joincategorieentite';
$this->params['breadcrumbs'][] = ['label' => 'Joincategorieentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joincategorieentite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
