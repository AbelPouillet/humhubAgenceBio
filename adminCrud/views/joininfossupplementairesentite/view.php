<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joininfossupplementairesentite $model */

$this->title = $model->cet_infos_supplementaires_id;
$this->params['breadcrumbs'][] = ['label' => 'Joininfossupplementairesentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="joininfossupplementairesentite-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'cet_infos_supplementaires_id' => $model->cet_infos_supplementaires_id, 'cet_entite_id' => $model->cet_entite_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'cet_infos_supplementaires_id' => $model->cet_infos_supplementaires_id, 'cet_entite_id' => $model->cet_entite_id], [
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
            'cet_infos_supplementaires_id',
            'cet_entite_id',
        ],
    ]) ?>

</div>
