<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinadresseentite $model */

$this->title = $model->cet_adresse_operateur_id;
$this->params['breadcrumbs'][] = ['label' => 'Joinadresseentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="joinadresseentite-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'cet_adresse_operateur_id' => $model->cet_adresse_operateur_id, 'cet_entite_id' => $model->cet_entite_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'cet_adresse_operateur_id' => $model->cet_adresse_operateur_id, 'cet_entite_id' => $model->cet_entite_id], [
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
            'cet_adresse_operateur_id',
            'cet_entite_id',
        ],
    ]) ?>

</div>
