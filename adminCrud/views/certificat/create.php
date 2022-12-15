<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Certificat $model */

$this->title = 'Create Certificat';
$this->params['breadcrumbs'][] = ['label' => 'Certificats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
