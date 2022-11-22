<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cetcal_model\Infossupplementairesvaleur */

$this->title = 'Create Infossupplementairesvaleur';
$this->params['breadcrumbs'][] = ['label' => 'Infossupplementairesvaleurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="infossupplementairesvaleur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
