<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<tr>
    <td> <?= Html::encode($cet_entite->id); ?></td>
    <!--TODO Localost à changer en prod -->
    <td><a href="<?= Url::to([
                        '/cet_entite/detail',
                        'id' => $cet_entite->id,
                    ])
                    ?>" target="_blank">
            <?= Html::encode($cet_entite->denominationcourante); ?> </a></td>
    <td><?= Html::encode($cet_entite->getFormatedAdresse1()); ?></td>
    <td><?= Html::encode($cet_entite->getFormatedAdresse2()); ?></td>
    <td><?= Html::encode($cet_entite->getFormatedAdresse3()); ?></td>

    <td><?= Html::encode($cet_entite->getFormatedTypes()); ?></td>
    <td><?= Html::encode($cet_entite->gerant); ?></td>
    <td><?= Html::encode($cet_entite->email); ?></td>
    <td><?= Html::encode($cet_entite->telephone); ?></td>
    <td><?= Html::encode($cet_entite->telephoneCommerciale); ?></td>
    <td>
        <?php foreach ($cet_entite->getEntiteTags()->all() as $tag) : ?>
            <?= Html::encode($tag->nom); ?>
            &nbsp;
        <?php endforeach ?>
    </td>
</tr>
