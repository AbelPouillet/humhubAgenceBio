<?php

use app\models\cetcal_model\Entite;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search_model\EntiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entites';
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
                url: 'index.php?r=entite%2Fload',

            }).done(function(data) {
                $('#isloading').hide();
                console.log(data);
            }).catch(error => {
                $('#isloading').hide();
                console.error(error); 
            })
        })
        $('#islinking').hide();

        $('#link').on('click', async function() {
            $('#islinking').show();
            $.ajax({
                type: 'GET',
                url: 'index.php?r=entite%2Flink',

            }).done(function(data) {
                $('#islinking').hide();
                console.log(data);
            }).catch(error => {
                $('#islinking').hide();
                console.error(error); 
            })
        })
    });


</script>

<div class="entite-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Entite', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <button id="load" type="button" class="col-2 btn btn-primary">
        <i id="isloading" class="fa fa-circle-o-notch fa-spin"></i> Loading
    </button>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <button id="link" type="button" class="col-2 btn btn-primary">
        <i id="islinking" class="fa fa-circle-o-notch fa-spin"></i> Link Type
    </button>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'raisonSociale',
            'denominationcourante',
            'siret',
            'numeroBio',
            //'telephone',
            //'email:email',
            //'codeNAF',
            //'gerant',
            //'dateMaj',
            //'telephoneCommerciale',
            //'reseau',
            //'mixite',
            //'provenance',
            //'isActive:boolean',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Entite $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>