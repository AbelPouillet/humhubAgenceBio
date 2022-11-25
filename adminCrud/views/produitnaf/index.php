<?php

use app\models\cetcal_model\Produitnaf;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\ProduitnafSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produitnafs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produitnaf-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Produitnaf', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'codenaf',
            'libelle',
            'cet_produit_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Produitnaf $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'cet_produit_id' => $model->cet_produit_id]);
                 }
            ],
        ],
    ]); ?>


</div>
