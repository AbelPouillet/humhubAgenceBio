<?php
use yii\bootstrap\Html;

if ($link == true) :
    echo Html::beginTag('a', $linkOptions);
endif;
echo Html::beginTag('div', $acronymHtmlOptions);
echo $acronym;
echo Html::endTag('div');
//TODO ajouter les liens vers les images des types
//echo Html::img($type->getProfileImage()->getUrl(), $imageHtmlOptions);
if ($link == true) :
    echo Html::endTag('a');
endif;
?>
