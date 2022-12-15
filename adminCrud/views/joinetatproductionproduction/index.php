<?php

use app\models\cetcal_model\Joinetatproductionproduction;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\JoinetatproductionproductionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Joinetatproductionproductions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joinetatproductionproduction-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Joinetatproductionproduction', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cet_etat_production_id',
            'cet_production_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Joinetatproductionproduction $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'cet_etat_production_id' => $model->cet_etat_production_id, 'cet_production_id' => $model->cet_production_id]);
                 }
            ],
        ],
    ]); ?>


</div>
