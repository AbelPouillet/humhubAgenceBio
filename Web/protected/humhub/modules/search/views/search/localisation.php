<?php

use yii\helpers\Url;

?>
<html>

<body>
    <div class="row">
        <!-- TODO url prod -->
        <div class="col-12 col-sm-6" style="text-align: center;">
            <a id="ouiloca" href="http://localhost:9081/index.php?r=search%2Fsearch%2Findex&SearchForm%5Bscope%5D=cet_entite&SearchForm%5BlimitCommunesIds%5D%5B0%5D=32759&SearchForm%5BdistanceRecherche%5D=10&SearchForm%5Bavancee%5D=1" class="btn btn-primary">
                Oui utilisez ma localisation </a>
        </div>
        <div class="col-12 col-sm-6" style="text-align: center;">
            <a id="nonloca" href="<?= Url::to([
                                        '/search/search/index',
                                        'SearchForm[scope]' => 'cet_entite',
                                        'SearchForm[limitCommunesIds]' => [32759],
                                        'SearchForm[distanceRecherche]' => 10,
                                        'SearchForm[avancee]' => true,
                                    ]) ?>
            " class=" btn btn-danger">Non je veux les résultats autour de Castillon la Bataille
            </a>
        </div>
    </div>
</body>

<script>
    function getLocation() {

        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(redirectToPosition, noPosition);
        }
    }

    function noPosition() {

        $("#ouiloca").attr('disabled', true);
        $("#ouiloca").prop("href", "#");
    }

    function redirectToPosition(position) {

        if (position) {
            //TODO url prod
            $("#ouiloca").prop("href", "http://localhost:9081/index.php?r=search%2Fsearch%2Findex&SearchForm%5Bscope%5D=cet_entite&SearchForm%5Buserlat%5D=" +
                position.coords.latitude + "&SearchForm%5Buserlong%5D=" + position.coords.longitude +
                "&SearchForm%5BdistanceRecherche%5D=10&SearchForm%5Bavancee%5D=1");

        }
    }
    getLocation();

</script>

</html>
