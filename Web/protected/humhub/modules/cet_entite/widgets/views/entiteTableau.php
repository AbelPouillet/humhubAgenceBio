<?php

use yii\helpers\Html;
?>

<tr><td> <?= Html::encode($cet_entite->id); ?></td>
<td> <?= Html::encode($cet_entite->denominationcourante); ?></td>
<td><?= Html::encode($cet_entite->getFormatedAdresse1()); ?></td>
<td><?= Html::encode($cet_entite->getFormatedAdresse2()); ?></td>
<td><?= Html::encode($cet_entite->getFormatedAdresse3()); ?></td>

<td><?= Html::encode($cet_entite->getFormatedTypes()); ?></td>
<td><?= Html::encode($cet_entite->gerant); ?></td>
<td><?= Html::encode($cet_entite->email); ?></td>
<td><?= Html::encode($cet_entite->telephone); ?></td>
<td><?= Html::encode($cet_entite->telephoneCommerciale); ?></td></tr>
