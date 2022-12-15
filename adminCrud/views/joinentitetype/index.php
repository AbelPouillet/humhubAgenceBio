<?php

use app\models\cetcal_model\Joinentitetype;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\JoinentitetypeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Joinentitetypes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joinentitetype-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Joinentitetype', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cet_entite_id',
            'cet_type_id',
            'isDefault:boolean',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Joinentitetype $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'cet_entite_id' => $model->cet_entite_id, 'cet_type_id' => $model->cet_type_id]);
                 }
            ],
        ],
    ]); ?>


</div>
