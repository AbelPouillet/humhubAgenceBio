<?php

use yii\helpers\Html;
?>

<div class="panel panel-default">
    <div class="panel-body">

        <div class="media">
            <div class="media-body">
                <!-- A MODIFIER URL PROD -->
                <h4 class="media-heading"><a href="http://localhost:9081/index.php?r=cet_entite%2Fdetail&id=<?=$cet_entite->id ?>" target="_blank"><?= Html::encode($cet_entite->denominationcourante ? $cet_entite->denominationcourante : $cet_entite->raisonSociale ); ?></a> </h4>
                <?php if($cet_entite->getCategoriesStr() !== ""): ?>
                <h5>Categories : <?= Html::encode($cet_entite->getCategoriesStr()); ?></h5>
                <?php endif ?>
                <?php if($cet_entite->getActivitesStr() !== ""): ?>
                <h5>Activites : <?= Html::encode($cet_entite->getActivitesStr()); ?></h5>
                <?php endif ?>
                <?php if($cet_entite->getProductionsStr() !== ""): ?>
                <h5>Productions : <?= Html::encode($cet_entite->getProductionsStr()); ?></h5>
                <?php endif ?>
                <?php if($cet_entite->getTypeStr() !== ""): ?>
                    <h5>Types :<?= Html::encode($cet_entite->getTypeStr()); ?></h5>
                <?php endif ?>
            </div>
        </div>

    </div>
</div>
