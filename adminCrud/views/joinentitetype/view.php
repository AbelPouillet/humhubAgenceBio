<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinentitetype $model */

$this->title = $model->cet_entite_id;
$this->params['breadcrumbs'][] = ['label' => 'Joinentitetypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="joinentitetype-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'cet_entite_id' => $model->cet_entite_id, 'cet_type_id' => $model->cet_type_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'cet_entite_id' => $model->cet_entite_id, 'cet_type_id' => $model->cet_type_id], [
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
            'cet_entite_id',
            'cet_type_id',
            'isDefault:boolean',
        ],
    ]) ?>

</div>
