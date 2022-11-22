<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cetcal_model\Infossupplementairesvaleur */

$this->title = 'Update Infossupplementairesvaleur: ' . $model->cet_entite_id;
$this->params['breadcrumbs'][] = ['label' => 'Infossupplementairesvaleurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_entite_id, 'url' => ['view', 'cet_entite_id' => $model->cet_entite_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="infossupplementairesvaleur-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
