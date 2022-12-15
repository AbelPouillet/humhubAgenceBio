<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joincategorieentite $model */

$this->title = 'Update Joincategorieentite: ' . $model->cet_categorie_id;
$this->params['breadcrumbs'][] = ['label' => 'Joincategorieentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_categorie_id, 'url' => ['view', 'cet_categorie_id' => $model->cet_categorie_id, 'cet_entite_id' => $model->cet_entite_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="joincategorieentite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
