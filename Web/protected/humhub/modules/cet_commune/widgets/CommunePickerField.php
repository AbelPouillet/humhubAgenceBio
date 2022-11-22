<?php

namespace humhub\modules\cet_commune\widgets;

use humhub\modules\cet_commune\models\CetCommune;
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
class CommunePickerField extends BasePicker
{
    /**
     * @inheritdoc
     * Min guids string value of Type model equal 2
     */
    public $minInput = 2;

    /**
     * @inheritdoc
     */
    public $defaultRoute = '/cet_commune/browse/search';
    public $itemClass = CetCommune::class;
    public $itemKey = 'id';

    //public $jsWidget = "type.chooser.TypeChooser";
    /**
     * @inheritdoc
     */
    protected function getData()
    {
        $result = parent::getData();
        $allowMultiple = $this->maxSelection !== 1;
        $result['placeholder'] = $allowMultiple ? "Sélectionner vos communes " : "Sélectionner votre commune";
        $result['placeholder-more'] = "Ajouter une commune";
        $result['no-result'] = "Pas de communes correspondant à votre recherche";

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
        return Image::widget(['commune' => $item, 'width' => 24]);
    }

    public function run()
    {
        if ($this->selection != null && !is_array($this->selection)) {
            $this->selection = [$this->selection];
        }

        // Prepare current selection and selection options
        $selection = [];
        $selectedOptions = $this->getSelectedOptions();
        foreach ($selectedOptions as $id => $option) {
            $selection[$id] = $option['data-text'];
        }

        $options = $this->getOptions();
        $options['options'] = $selectedOptions;

        if ($this->form != null) {
            return $this->form->field($this->model, $this->attribute)->dropDownList($selection, $options);
        } elseif ($this->model != null) {
            return Html::activeDropDownList($this->model, $this->attribute, $selection, $options);
        } else {
            $name = (!$this->name) ? 'pickerField' : $this->name;
            return Html::dropDownList($name, $this->value, $selection, $options);
        }
    }

}
