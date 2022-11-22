<?php

use yii\helpers\Html;

?>

<div class="container panel">
    <h4 class="panel-heading"><?= $cet_entite->name ?></h4>
    <div class="panel-body">
        <label>Adresse: </label><span><?= ' ' . $cet_entite->street . ' ' . $cet_entite->city . ' ' . $cet_entite->zip ?></span>
        <br>
        <?php if (isset($cet_entite->telFixe)) : ?>
            <label>Téléphone fixe: </label>
            <span>
                <?= $cet_entite->telFixe ?>
            </span>
            <br>
        <?php endif; ?>
        <?php if (isset($cet_entite->telMobile)) : ?>
            <label>Téléphone portable: </label>
            <span>
                <?= $cet_entite->telMobile ?>
            </span>
            <br>
        <?php endif; ?>
        <?php if (isset($cet_entite->email)) : ?>
            <label>Mail : </label>
            <span>
                <?= $cet_entite->email ?>
            </span>
            <br>
        <?php endif; ?>
        <label> Contact : </label>
        <span>
            <?= $cet_entite->contactPrenom . ' ' . $cet_entite->contactNom  ?>
        </span>
        <br>
        <label> Siret : </label>
        <span>
            <?= $cet_entite->siret ?>
        </span>
        <br>
        <?php if ($cet_entite->commentaire && strlen($cet_entite->commentaire) > 1) : ?>
            <label> Commentaire : </label>
            <span>
                <?= $cet_entite->commentaire ?>
            </span>
            <br>
        <?php endif; ?>
        <?php if ($cet_entite->urlWeb) : ?>
            <label> URL site web: </label>
            <a href="<?= $cet_entite->urlWeb ?>"><?= $cet_entite->urlWeb ?></a>
            <br>
        <?php endif; ?>
        <?php if ($cet_entite->urlFb) : ?>
            <label> URL Facebook: </label>
            <a href="<?= $cet_entite->urlFb ?>"><?= $cet_entite->urlFb ?></a>
            <br>
        <?php endif; ?>
        <?php if ($cet_entite->urlIg) : ?>
            <label> URL Instagram: </label>
            <a href="<?= $cet_entite->urlIg ?>"><?= $cet_entite->urlIg ?></a>
            <br>
        <?php endif; ?>
        <?php if ($cet_entite->urlTwitter) : ?>
            <label> URL Twitter: </label>
            <a href="<?= $cet_entite->urlTwitter ?>"><?= $cet_entite->urlTwitter ?></a>
            <br>
        <?php endif; ?>
        <?php if ($cet_entite->urlBoutique) : ?>
            <label> URL Boutique: </label>
            <a href="<?= $cet_entite->urlBoutique ?>"><?= $cet_entite->urlBoutique ?></a>
            <br>
        <?php endif; ?>
        <?php if ($cet_entite->type == 'producteur') : ?>
            <div class="producteurInfos">
                <?= var_dump($cet_entite->pk0) ?>
                <?php if ($cet_entite->pk0->orgcertifbio) : ?>
                    <label> Organisme de certification bio : </label>
                    <span><?= $cet_entite->pk0->orgcertifbio ?></span>
                    <br>
                <?php endif; ?>
                <?php if ($cet_entite->pk0->urlcertifab) : ?>
                    <label> URL certification bio : </label>
                    <a href="<?= $cet_entite->urlcertifab ?>"><?= $cet_entite->urlcertifab ?></a>
                    <br>
                <?php endif; ?>
                <?php if ($cet_entite->pk0->niv_certif_ab) : ?>
                    <label> Statue de certification bio : </label>
                    <?php if($cet_entite->pk0->niv_certif_ab == 1) : ?>
                        <span> Certifier </span>
                    <?php elseif($cet_entite->pk0->niv_certif_ab == 2) : ?>
                        <span> en cours de certification </span>
                    <?php elseif($cet_entite->pk0->niv_certif_ab == 3) : ?>
                        <span> agriculture éthique non certifier </span>
                    <?php elseif($cet_entite->pk0->niv_certif_ab == 4) : ?>
                        <span>Certification non à jour</span>
                    <?php endif; ?>
                    <br>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="amapInfos">
            </div>
        <?php endif; ?>
        <?= var_dump($cet_entite) ?>
    </div>
</div>
