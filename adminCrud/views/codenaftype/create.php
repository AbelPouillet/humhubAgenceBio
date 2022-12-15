<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Codenaftype $model */

$this->title = 'Create Codenaftype';
$this->params['breadcrumbs'][] = ['label' => 'Codenaftypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="codenaftype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
