<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinadresseentite $model */

$this->title = 'Update Joinadresseentite: ' . $model->cet_adresse_operateur_id;
$this->params['breadcrumbs'][] = ['label' => 'Joinadresseentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_adresse_operateur_id, 'url' => ['view', 'cet_adresse_operateur_id' => $model->cet_adresse_operateur_id, 'cet_entite_id' => $model->cet_entite_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="joinadresseentite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
