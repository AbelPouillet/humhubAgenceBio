<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cetcal_model\Infossupplementaires */

$this->title = 'Create Infossupplementaires';
$this->params['breadcrumbs'][] = ['label' => 'Infossupplementaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="infossupplementaires-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
