<?php

namespace humhub\modules\cet_type\widgets;

use humhub\modules\cet_type\models\CetType;
use humhub\modules\ui\form\widgets\BasePicker;
use Yii;
use yii\helpers\Html;

/**
 * Mutliselect input field for selecting type guids.
 *
 * @package humhub.modules_core.type.widgets
 * @since 1.2
 * @author buddha
 */
class TypePickerField extends BasePicker
{
    /**
     * @inheritdoc
     * Min guids string value of Type model equal 2
     */
    public $minInput = 2;

    /**
     * @inheritdoc
     */
    public $defaultRoute = '/cet_type/browse/search';
    public $itemClass = CetType::class;
    public $itemKey = 'id';

    //public $jsWidget = "type.chooser.TypeChooser";
    /**
     * @inheritdoc
     */
    protected function getData()
    {
        $result = parent::getData();
        $allowMultiple = $this->maxSelection !== 1;
        $result['placeholder'] = $allowMultiple ? "Sélectionner vos types de recherches" : "Sélectionner votre type de recherche";
        $result['placeholder-more'] = "Ajouter un type de recherche ";
        $result['no-result'] = "Pas de types correspondant à votre recherche";

        if ($this->maxSelection) {
            $result['maximum-selected'] = $this->maxSelection;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function getItemText($item)
    {
        return $item->getDisplayName();
    }

    /**
     * @inheritdoc
     */
    protected function getItemImage($item)
    {
        return Image::widget(['type' => $item, 'width' => 24]);
    }

}
