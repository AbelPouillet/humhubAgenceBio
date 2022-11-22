<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Documentation</h1>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h2> Liaisons entre les tables</h2>
                <p>Pour lier par exemple les tables produit et entite Créer un joinproduit avec dans les champs suivants :</p>
                <?= Html::img('@web/assets/images/CreateJoinproduit.png', ['alt'=>'joinproduit', 'width'=>'100%']);?>
                <p> L'id de l'entite dans Fk Adresse Cet </p>
                <?= Html::img('@web/assets/images/EntiteId.png', ['alt'=>'entite Id', 'width'=>'100%']);?>
                <p> L'id du produit dans Fk Produit </p>
                <?= Html::img('@web/assets/images/ProduitId.png', ['alt'=>'produit Id', 'width'=>'100%']);?>
            </div>
            <div class="col-lg-8">
                <h2> Reconstruction de l'index de recherche </h2>
                <p> Aprés avoir modifier les tables on a besoin de reconstruire l'index de recherche dans humhub dans le menu administration section information onglet Base de Données</p>
                <?= Html::img('@web/assets/images/ReconstructionIndex.png', ['alt'=>'reconstruction index', 'width'=>'100%']);?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
