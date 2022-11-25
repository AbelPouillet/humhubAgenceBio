<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Produitnaf $model */

$this->title = $model->cet_produit_id;
$this->params['breadcrumbs'][] = ['label' => 'Produitnafs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="produitnaf-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'cet_produit_id' => $model->cet_produit_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'cet_produit_id' => $model->cet_produit_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codenaf',
            'libelle',
            'cet_produit_id',
        ],
    ]) ?>

</div>
