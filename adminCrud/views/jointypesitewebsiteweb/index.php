<?php

use app\models\cetcal_model\Jointypesitewebsiteweb;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\JointypesitewebsitewebSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jointypesitewebsitewebs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jointypesitewebsiteweb-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Jointypesitewebsiteweb', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cet_type_site_web_id',
            'cet_site_web_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Jointypesitewebsiteweb $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'cet_type_site_web_id' => $model->cet_type_site_web_id, 'cet_site_web_id' => $model->cet_site_web_id]);
                 }
            ],
        ],
    ]); ?>


</div>
