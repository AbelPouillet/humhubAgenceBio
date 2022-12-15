<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-dark bg-dark fixed-top navbar-expand-md',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index'] , 'dropdownOptions' =>['']],
            /*['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],*/
            ['label' => 'Entité', 'url' => ['/entite/index']],
            ['label' => 'Produit', 'url' => ['/produit/index']],
            ['label' => 'Produitnaf', 'url' => ['/produitnaf/index']],
            ['label' => 'Infos Supplementaire', 'url' => ['/infossupplementaires/index']],
            ['label' => 'Valeur infos supplementaires', 'url' => ['/infossupplementairesvaleur/index']],
            ['label' => 'Communes', 'url' => ['/communes/index']],
            ['label' => 'Activités', 'url' => ['/activite/index']],
            ['label' => 'Adresse' , 'url' => ['/adresse/index']],
            ['label' => 'Catégorie', 'url' => ['/categorie/index']],
            ['label' => 'état production', 'url' => ['/etatproduction/index']],
            ['label' => 'Certificat', 'url' => ['/certificat/index']],
            ['label' => 'CodeNaf Type', 'url' => ['/codenaftype/index']],
            ['label' =>' Tables de jointure','dropdownOptions' => ['class' => 'pre-scrollable'],
            'items' => [['label' => 'Join Activités Entités', 'url' => ['/joinactiviteentite/index']],
                ['label' => 'Join Adresses Entités', 'url' => ['/joinadresseentite/index']],
                ['label' => 'Join Catégories Entités', 'url' => ['/joincategorieentite/index']],
                ['label' => 'Join Types Entités', 'url' => ['/joinentitetype/index']],
                ['label' => 'Join état-production Production', 'url' => ['/joinetatproductionproduction/index']],
                ['label' => 'Join infos supplementaire Entités', 'url' => ['/joininfossupplementairesentite/index']],
                ['label' => 'Join Production Entités', 'url' => ['/joinproductionentite/index']],
                ['label' => 'Join SiteWeb Entités', 'url' => ['/joinsitewebentite/index']],
                ['label' => 'Join SiteWeb TypeSiteWeb', 'url' => ['/jointypesitewebsiteweb/index']],]
            ],
            ['label' => 'Production', 'url' => ['/production/index']],
            ['label' => 'SiteWeb', 'url' => ['/siteweb/index']],
            ['label' => 'Type', 'url' => ['/type/index']],
            ['label' => 'Type SiteWeb', 'url' => ['/typesiteweb/index']],



            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; My Company <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
