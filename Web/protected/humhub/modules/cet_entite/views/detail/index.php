<?php

use humhub\modules\cet_infos_supplementaires_valeur\models\Infossupplementairesvaleur;
use humhub\modules\cet_entite\widgets\EntiteTagPicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
                echo isset($adresseCet->typeadresses[0]->nom) ? '<div> <strong>Type Adresse : </strong>' . $adresseCet->typeadresses[0]->nom . ' </div>' : '';
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
        if ($cet_entite->certificats) {
            foreach ($cet_entite->certificats as $certificat) {
                echo isset($certificat->organisme) ? '<div> <strong>Organisme : </strong>' . $certificat->organisme . '</div>' : '';
                echo isset($certificat->etatCertification) ? '<div> <strong>Etat Certification : </strong>' . $certificat->etatCertification . '</div>' : '';
                echo isset($certificat->url) ? '<strong>Certificat :</strong><a href=' . $certificat->url . '> ' . $certificat->url . ' </a><br>' : '';
                echo isset($certificat->dateEngagement) ? '<div> <strong>Date Engagement : </strong>' . $certificat->dateEngagement . '</div>' : '';
            }
        }
        if ($cet_entite->sitewebs) {
            foreach ($cet_entite->sitewebs as $siteweb) {
                echo isset($siteweb->url) ? '<strong>'.$siteweb->getTypesitewebsStr().':</strong> <a href=' . $siteweb->url . '>' . $siteweb->url . '</a><br>' : '';
            }
        }
        if ($cet_entite->infossupplementaires) {
            foreach ($cet_entite->infossupplementaires as $infossupplementaire) {
                $valeur = Infossupplementairesvaleur::findOne(['cet_entite_id' => $cet_entite->id, 'pk_cet_infos_supplementaires' => $infossupplementaire->id]);
                echo '<div><strong>' . $infossupplementaire->label . ':</strong> ' . $valeur->valeur . '</div>';
            }
        }
        ?>
    </div>

    <?php if (Yii::$app->user->isAdmin()) : ?>
        <div>
            <h2>Formulaire d'Adminstration</h2>
            <?php $form = ActiveForm::begin(['action'=> Url::to([
                'adminpost',
                'id' => $cet_entite->id
            ]), 'method' => 'POST']); ?>
            <?= $form->field($adminForm, 'nomDusage')->textInput(['label'=>"Nom d'usage"]) ?>
            <?= $form->field($adminForm, 'adresse')->textInput(['label'=>"Adresse"]) ?>
            <?= $form->field($adminForm, 'telephone')->textInput(['label'=>"Telephone"]) ?>
            <?= $form->field($adminForm, 'email')->textInput(['label'=>"Email"]) ?>
            <?= $form->field($adminForm, 'siteweb')->textInput(['label'=>"Site Web"]) ?>
            <?=  $form->field($adminForm, 'tags')
            ->widget(EntiteTagPicker::class, ['entiteID' => $cet_entite->id])->label("Etiquette(s)") ?>
            <?= Html::submitButton('Enregistrer') ?>
            <?php ActiveForm::end(); ?>
        </div>
    <?php endif ?>
</div>
