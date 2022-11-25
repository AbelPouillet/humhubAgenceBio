<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Produitnaf $model */

$this->title = 'Create Produitnaf';
$this->params['breadcrumbs'][] = ['label' => 'Produitnafs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produitnaf-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
