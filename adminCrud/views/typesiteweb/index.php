<?php

use app\models\cetcal_model\Typesiteweb;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\TypesitewebSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Typesitewebs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="typesiteweb-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Typesiteweb', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nom',
            'status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Typesiteweb $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
