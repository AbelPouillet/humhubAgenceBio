<?php

use app\models\cetcal_model\Certificat;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\CertificatSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Certificats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Certificat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'pk_cet_entite',
            'organisme',
            'etatCertification',
            'dateSuspension',
            //'dateArret',
            //'dateEngagement',
            //'dateNotification',
            //'url:url',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Certificat $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
