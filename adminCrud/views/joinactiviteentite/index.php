<?php

use app\models\cetcal_model\Joinactiviteentite;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\JoinactiviteentiteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Joinactiviteentites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joinactiviteentite-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Joinactiviteentite', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cet_activite_id',
            'cet_entite_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Joinactiviteentite $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'cet_activite_id' => $model->cet_activite_id, 'cet_entite_id' => $model->cet_entite_id]);
                 }
            ],
        ],
    ]); ?>


</div>
