<?php

use yii\helpers\Html;

?>

<div class="container panel">
    <h4 class="panel-heading">
        <?= isset($cet_entite->denominationcourante) ?
         $cet_entite->denominationcourante  : $cet_entite->raisonSociale ?>
    </h4>
    <div class="panel-body">
        <?= $cet_entite->siret ? '<div> Siret : '. $cet_entite->siret .'</div>' : ''?>
        <?= $cet_entite->numeroBio ? '<div> Numéro Bio : '. $cet_entite->numeroBio .'</div>' : ''?>
        <?= $cet_entite->telephone ? '<div> Téléphone : '. $cet_entite->telephone .'</div>' : ''?>
        <?= $cet_entite->telephoneCommerciale ? '<div> Téléphone Commerciale: '. $cet_entite->telephoneCommerciale .'</div>' : ''?>
        <?= $cet_entite->email ? '<div> Email : '. $cet_entite->email .'</div>' : ''?>
        <?= $cet_entite->gerant ? '<div> Gérant : '. $cet_entite->gerant .'</div>' : ''?>
        <?= $cet_entite->reseau ? '<div> Réseau : '. $cet_entite->reseau .'</div>' : ''?>
        <?= $cet_entite->getActivitesStr() ? '<div> Activites : '.$cet_entite->getActivitesStr().'</div>' : ''?>
        <?= $cet_entite->getCategoriesStr() ? '<div> Catégories : '.$cet_entite->getCategoriesStr().'</div>' : ''?>
        <?= $cet_entite->getProductionsStr() ? '<div> Productions : '.$cet_entite->getProductionsStr().'</div>' : ''?>
        <?php
            if ($cet_entite->adresses) {
                foreach ($cet_entite->adresses as $adresseCet){
                    echo isset($adresseCet->typeadresses->nom) ? '<div> '.$adresseCet->typeadresses->nom .' </div>' : '';
                }
            }
        ?>
        <?= var_dump($cet_entite) ?>
    </div>
</div>
