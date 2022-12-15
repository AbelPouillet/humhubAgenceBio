<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinactiviteentite $model */

$this->title = 'Create Joinactiviteentite';
$this->params['breadcrumbs'][] = ['label' => 'Joinactiviteentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joinactiviteentite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
