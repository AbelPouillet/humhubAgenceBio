<?php
use humhub\widgets\Button;
?>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Run Cron</strong> <?= Yii::t('ExampleModule.base', 'configuration') ?></div>

        <div class="panel-body">
            <p><?= Yii::t('ExampleModule.base', 'Cron is running') ?></p>
            <?php
            if($res){
                echo '<p>'.$res. $cpt.' times </p>';
            }
            else
            {
                $cpt = 0;
            }
                echo Button::primary(Yii::t('ExampleModule.base', 'Import'))->link("index.php?r=example%2Fadmin%2Fimport&cpt=".$cpt);
            ?>

        </div>
    </div>
</div>
