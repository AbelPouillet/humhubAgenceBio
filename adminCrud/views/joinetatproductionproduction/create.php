<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinetatproductionproduction $model */

$this->title = 'Create Joinetatproductionproduction';
$this->params['breadcrumbs'][] = ['label' => 'Joinetatproductionproductions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joinetatproductionproduction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
