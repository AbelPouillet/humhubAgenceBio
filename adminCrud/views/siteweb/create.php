<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Siteweb $model */

$this->title = 'Create Siteweb';
$this->params['breadcrumbs'][] = ['label' => 'Sitewebs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="siteweb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
