<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Typesiteweb $model */

$this->title = 'Create Typesiteweb';
$this->params['breadcrumbs'][] = ['label' => 'Typesitewebs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="typesiteweb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
