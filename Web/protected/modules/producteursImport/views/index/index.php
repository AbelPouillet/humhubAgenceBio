<?php

use humhub\widgets\Button;

// Register our module assets, this could also be done within the controller
\humhub\modules\producteursImport\assets\Assets::register($this);

$displayName = (Yii::$app->user->isGuest) ? Yii::t('ProducteursImportModule.base', 'Guest') : Yii::$app->user->getIdentity()->displayName;

// Add some configuration to our js module
$this->registerJsConfig("producteursImport", [
    'username' => (Yii::$app->user->isGuest) ? $displayName : Yii::$app->user->getIdentity()->username,
    'text' => [
        'hello' => Yii::t('ProducteursImportModule.base', 'Hi there {name}!', ["name" => $displayName])
    ]
])

?>

<div class="panel-heading"><strong>Run Cron</strong> <?= Yii::t('ProducteursImportModule.base', 'overview') ?></div>

<?php
use mysqli;
// on se connecte à la base MySQL
$db = new mysqli('cetcal_db', 'user', 'user', 'cetcal');
// on crée la requête SQL
$sql = 'SELECT nom,prenom,email,adrferme_numvoie,adrferme_rue,adrferme_lieudit,adrferme_commune,adrferme_cp,adrferme_compladr,nom_ferme,prod_active FROM cetcal_producteur WHERE email = "friedman.valerie@orange.fr"';
// on envoie la requête
$req = mysqli_query($db, $sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysqli_error($db));

$bizarrerie = array('é', 'à', "'", 'ê', 'è', '°', 'Ô', 'ï', 'ç', 'â', 'û', 'î', 'ù', 'ë');

$remplacementBizzarerie = array(utf8_decode('é'),utf8_decode('à'),utf8_decode("'"),utf8_decode('ê'),utf8_decode('è'), utf8_decode('°'), utf8_decode('Ô'), utf8_decode('ï'), utf8_decode('ç'), utf8_decode('â'), utf8_decode('û'), utf8_decode('î'), utf8_decode('ù'), utf8_decode('ë'));

// on fait une boucle qui va faire un tour pour chaque enregistrement
while ($data = mysqli_fetch_assoc($req)) {
    $encoding = mb_detect_encoding($data['nom_ferme']);
    echo $encoding .' ';
    if(iconv($encoding, "ascii//TRANSLIT//IGNORE", utf8_decode($data['nom_ferme']))){
        echo utf8_decode($data['nom_ferme']) . '<br>';
        echo iconv($encoding, "ascii//TRANSLIT//IGNORE", utf8_decode($data['nom_ferme'])) . ' checked <br/>';
    } else {
        echo utf8_decode($data['nom_ferme']) . ' checked but not convert <br/>';
    }
    echo str_replace($bizarrerie , $remplacementBizzarerie , $data['nom_ferme']) . '<br/>';
    echo utf8_decode($data['nom_ferme']) . '<br/>';
    echo $data['nom_ferme'] . '<br/>';
    echo iconv($encoding, "ISO-8859-1//TRANSLIT//IGNORE", $data['nom_ferme']) . '<br/>';
    echo iconv($encoding, "ISO-8859-15//TRANSLIT//IGNORE", $data['nom_ferme']) . '<br/>';
    echo iconv($encoding, "ASCII//TRANSLIT//IGNORE", $data['nom_ferme']) . ' ASCII <br/>';
    echo iconv($encoding, "CP1256//TRANSLIT//IGNORE", $data['nom_ferme']) . '<br/>';
    echo iconv($encoding, "ISO-8859-6//TRANSLIT//IGNORE", $data['nom_ferme']) . '<br/>';
    echo $data['nom_ferme'] . '<br/>';


    echo utf8_decode('é') . '<br/>';

    echo iconv("ISO-8859-1", "UTF-8", $data['nom_ferme']) . '<br/>';
}
// on ferme la connexion à mysql
mysqli_close($db);

?>

<div class="panel-body">
    <p><?= Yii::t('ProducteursImportModule.base', 'Hello World!') ?></p>

    <?=  Button::primary(Yii::t('ProducteursImportModule.base', 'Say Hello!'))->action("producteursImport.hello")->loader(false); ?></div>
