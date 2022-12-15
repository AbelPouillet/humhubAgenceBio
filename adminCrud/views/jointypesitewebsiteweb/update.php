<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Jointypesitewebsiteweb $model */

$this->title = 'Update Jointypesitewebsiteweb: ' . $model->cet_type_site_web_id;
$this->params['breadcrumbs'][] = ['label' => 'Jointypesitewebsitewebs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cet_type_site_web_id, 'url' => ['view', 'cet_type_site_web_id' => $model->cet_type_site_web_id, 'cet_site_web_id' => $model->cet_site_web_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jointypesitewebsiteweb-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
