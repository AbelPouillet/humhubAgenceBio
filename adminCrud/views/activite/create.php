<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cetcal_model\Activite */

$this->title = 'Create Activite';
$this->params['breadcrumbs'][] = ['label' => 'Activites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
