<?php

use app\models\cetcal_model\Codenaftype;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\CodenaftypeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Codenaftypes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="codenaftype-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Codenaftype', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cet_type_id',
            'codeNaf',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Codenaftype $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id, 'cet_type_id' => $model->cet_type_id]);
                 }
            ],
        ],
    ]); ?>


</div>
