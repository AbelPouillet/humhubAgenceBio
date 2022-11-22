<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cetcal_model\Adresse */

$this->title = 'Create Adresse';
$this->params['breadcrumbs'][] = ['label' => 'Adresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adresse-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
