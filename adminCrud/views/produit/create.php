<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\cetcal_model\Produit $model */

$this->title = 'Create Produit';
$this->params['breadcrumbs'][] = ['label' => 'Produits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
