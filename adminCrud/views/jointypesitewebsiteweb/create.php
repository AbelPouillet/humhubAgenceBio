<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Jointypesitewebsiteweb $model */

$this->title = 'Create Jointypesitewebsiteweb';
$this->params['breadcrumbs'][] = ['label' => 'Jointypesitewebsitewebs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jointypesitewebsiteweb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
