<?php

use app\models\cetcal_model\Joincategorieentite;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\JoincategorieentiteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Joincategorieentites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joincategorieentite-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Joincategorieentite', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cet_categorie_id',
            'cet_entite_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Joincategorieentite $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'cet_categorie_id' => $model->cet_categorie_id, 'cet_entite_id' => $model->cet_entite_id]);
                 }
            ],
        ],
    ]); ?>


</div>
