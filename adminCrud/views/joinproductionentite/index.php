<?php

use app\models\cetcal_model\Joinproductionentite;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\JoinproductionentiteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Joinproductionentites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joinproductionentite-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Joinproductionentite', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cet_production_id',
            'cet_entite_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Joinproductionentite $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'cet_production_id' => $model->cet_production_id, 'cet_entite_id' => $model->cet_entite_id]);
                 }
            ],
        ],
    ]); ?>


</div>
