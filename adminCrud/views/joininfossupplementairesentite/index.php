<?php

use app\models\cetcal_model\Joininfossupplementairesentite;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\JoininfossupplementairesentiteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Joininfossupplementairesentites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joininfossupplementairesentite-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Joininfossupplementairesentite', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cet_infos_supplementaires_id',
            'cet_entite_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Joininfossupplementairesentite $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'cet_infos_supplementaires_id' => $model->cet_infos_supplementaires_id, 'cet_entite_id' => $model->cet_entite_id]);
                 }
            ],
        ],
    ]); ?>


</div>
