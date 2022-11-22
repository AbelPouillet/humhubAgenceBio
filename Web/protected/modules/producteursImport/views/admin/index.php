<?php
use humhub\widgets\Button;


?>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Import Producteurs</strong> </div>

        <div class="panel-body">
            <p>Import </p>

            <?php
            if($res){
                echo '<p>'. $cptAction .' times </p>';
                echo '<p>'.$res.'</p>';
            }
            else {
                echo Button::primary(Yii::t('ExampleModule.base', 'Import'))->link("index.php?r=producteursImport%2Fadmin%2Fimport&cptAction=".$cptAction);
            }
            ?>


        </div>
    </div>
</div>
