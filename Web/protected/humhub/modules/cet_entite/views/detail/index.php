<?php

use yii\helpers\Html;

?>

<div class="container panel">
    <h4 class="panel-heading">
        <?= isset($cet_entite->denominationcourante) ?
            $cet_entite->denominationcourante  : $cet_entite->raisonSociale ?>
    </h4>
    <div class="panel-body">
        <?= $cet_entite->siret ? '<div><strong> Siret : </strong>' . $cet_entite->siret . '</div>' : '' ?>
        <?= $cet_entite->numeroBio ? '<div><strong> Numéro Bio : </strong>' . $cet_entite->numeroBio . '</div>' : '' ?>
        <?= $cet_entite->telephone ? '<div> <strong>Téléphone : </strong>' . $cet_entite->telephone . '</div>' : '' ?>
        <?= $cet_entite->telephoneCommerciale ? '<div> <strong>Téléphone Commerciale: </strong>' . $cet_entite->telephoneCommerciale . '</div>' : '' ?>
        <?= $cet_entite->email ? '<div> <strong>Email : </strong>' . $cet_entite->email . '</div>' : '' ?>
        <?= $cet_entite->gerant ? '<div><strong> Gérant : </strong>' . $cet_entite->gerant . '</div>' : '' ?>
        <?= $cet_entite->reseau ? '<div> <strong>Réseau : </strong>' . $cet_entite->reseau . '</div>' : '' ?>
        <?php
        if ($cet_entite->adresses) {
            foreach ($cet_entite->adresses as $adresseCet) {
                echo isset($adresseCet->typeadresses[0]->nom)? '<div> <strong>Type Adresse : </strong>' . $adresseCet->typeadresses[0]->nom . ' </div>' : '';
                echo isset($adresseCet->lieu) ? '<div>&nbsp;&nbsp;&nbsp;<strong>Adresse : </strong>' . $adresseCet->lieu . ' </div>' : '';
                echo isset($adresseCet->codePostal) ? '<div>&nbsp;&nbsp;&nbsp;<strong>Code Postal : </strong>' . $adresseCet->codePostal . ' </div>' : '';
                echo isset($adresseCet->ville) ? '<div>&nbsp;&nbsp;&nbsp;<strong>Ville : </strong>' . $adresseCet->ville . ' </div>' : '';
            }
        }
        if ($cet_entite->getCategoriesStr()) {
            echo '<div> <strong>Categories : </strong>' . $cet_entite->getCategoriesStr() . ' </div>';
        }
        if ($cet_entite->getActivitesStr()) {
            echo '<div> <strong>Activites : </strong>' . $cet_entite->getActivitesStr() . ' </div>';
        }
        if ($cet_entite->getProductionsStr()) {
            echo '<div> <strong>Production : </strong>' . $cet_entite->getProductionsStr() . ' </div>';
        }
        if ($cet_entite->certificats){
            foreach($cet_entite->certificats as $certificat){
                echo isset($certificat->organisme) ? '<div> <strong>Organisme : </strong>' . $certificat->organisme . '</div>' : '';
                echo isset($certificat->etatCertification) ? '<div> <strong>Etat Certification : </strong>' . $certificat->etatCertification . '</div>' : '';
                echo isset($certificat->url) ? '<strong>Certificat :</strong><a href='.$certificat->url.'> '.$certificat->url.' </a><br>' : '';
                echo isset($certificat->dateEngagement) ? '<div> <strong>Date Engagement : </strong>'.$certificat->dateEngagement.'</div>' : '';
            }
        }
        if($cet_entite->sitewebs){
            foreach ($cet_entite->sitewebs as $siteweb){
                echo isset($siteweb->typesitewebs) ? '<a href='.$siteweb->url.'>'.$siteweb->getTypesitewebsStr().'</a><br>' : '';
            }
        }
        ?>
    </div>
</div>
