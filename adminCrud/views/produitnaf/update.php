<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Produitnaf $model */

$this->title = 'Update Produitnaf: ' . $model->cet_produit_id;
$this->params['breadcrumbs'][] = ['label' => 'Produitnafs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_produit_id, 'url' => ['view', 'cet_produit_id' => $model->cet_produit_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="produitnaf-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
