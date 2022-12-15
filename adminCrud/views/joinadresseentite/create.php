<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Joinadresseentite $model */

$this->title = 'Create Joinadresseentite';
$this->params['breadcrumbs'][] = ['label' => 'Joinadresseentites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joinadresseentite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
