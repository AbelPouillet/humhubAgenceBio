<?php

use app\models\cetcal_model\Joinadresseentite;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\JoinadresseentiteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Joinadresseentites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joinadresseentite-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Joinadresseentite', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cet_adresse_operateur_id',
            'cet_entite_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Joinadresseentite $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'cet_adresse_operateur_id' => $model->cet_adresse_operateur_id, 'cet_entite_id' => $model->cet_entite_id]);
                 }
            ],
        ],
    ]); ?>


</div>
