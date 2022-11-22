<?php

use yii\helpers\Html;
?>

<div class="panel panel-default">
    <div class="panel-body">

        <div class="media">
            <div class="media-body">
                <h4 class="media-heading"><?= Html::encode($cet_produit->nom); ?> </h4>
                <h5>Type : <?= Html::encode($cet_produit->categorie); ?></h5>
            </div>
        </div>

    </div>
</div>
