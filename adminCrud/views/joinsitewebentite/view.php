<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinsitewebentite $model */

$this->title = $model->cet_site_web_id;
$this->params['breadcrumbs'][] = ['label' => 'Joinsitewebentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="joinsitewebentite-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'cet_site_web_id' => $model->cet_site_web_id, 'cet_entite_id' => $model->cet_entite_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'cet_site_web_id' => $model->cet_site_web_id, 'cet_entite_id' => $model->cet_entite_id], [
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
            'cet_site_web_id',
            'cet_entite_id',
        ],
    ]) ?>

</div>
