<?php

use yii\helpers\Html;
?>

<div class="panel panel-default">
    <div class="panel-body">

        <div class="media">
            <div class="media-body">
                <!-- A MODIFIER URL PROD -->
                <h4 class="media-heading"><a href="http://localhost:8081/index.php?r=cet_entite%2Fdetail&id=<?=$cet_entite->id ?>"><?= Html::encode($cet_entite->name); ?></a> </h4>
                <h5>Type : <?= Html::encode($cet_entite->type); ?></h5>
                <h5>Produit : <?= Html::encode($cet_entite->produits); ?></h5>
            </div>
        </div>

    </div>
</div>
