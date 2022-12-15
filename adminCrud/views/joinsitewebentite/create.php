<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinsitewebentite $model */

$this->title = 'Create Joinsitewebentite';
$this->params['breadcrumbs'][] = ['label' => 'Joinsitewebentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joinsitewebentite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
