<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinsitewebentite $model */

$this->title = 'Update Joinsitewebentite: ' . $model->cet_site_web_id;
$this->params['breadcrumbs'][] = ['label' => 'Joinsitewebentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_site_web_id, 'url' => ['view', 'cet_site_web_id' => $model->cet_site_web_id, 'cet_entite_id' => $model->cet_entite_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="joinsitewebentite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
