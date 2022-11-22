<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cetcal_model\Etatproduction */

$this->title = 'Create Etatproduction';
$this->params['breadcrumbs'][] = ['label' => 'Etatproductions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etatproduction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
