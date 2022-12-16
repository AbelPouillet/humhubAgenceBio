<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Typeadresse $model */

$this->title = 'Create Typeadresse';
$this->params['breadcrumbs'][] = ['label' => 'Typeadresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="typeadresse-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
