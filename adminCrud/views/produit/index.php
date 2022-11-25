<?php

use app\models\cetcal_model\Produit;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search_model\ProduitSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produits';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#isloading').hide();

        $('#load').on('click', async function() {
            $('#isloading').show();
            $.ajax({
                type: 'GET',
                url: 'index.php?r=produit%2Fload',

            }).done(function(data) {
                $('#isloading').hide();
                console.log(data);
            }).catch(error => {
                $('#isloading').hide();
                console.error(error); 
            })
        })
    });


</script>
<div class="produit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Produit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <button id="load" type="button" class="btn btn-primary">
        <i id="isloading" class="fa fa-circle-o-notch fa-spin"></i> Loading
    </button>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'categorie',
            'nom',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Produit $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
