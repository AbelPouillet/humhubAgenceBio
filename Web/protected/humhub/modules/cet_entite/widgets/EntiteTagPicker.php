<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

namespace humhub\modules\cet_entite\widgets;


use humhub\libs\Html;
use humhub\modules\cet_entite\models\Entite;
use Yii;
use humhub\modules\ui\form\widgets\BasePicker;
use humhub\modules\cet_entite\models\EntiteTag;
use yii\helpers\Url;

/**
 * This InputWidget provides a generic ContentTag Dropdown
 *
 *
 * @package humhub\modules\content\widgets
 */
class EntiteTagPicker extends BasePicker
{
    /**
     * @var string tagClass
     */
    public $itemClass = EntiteTag::class;

    /**
     * @var string tagClass
     */
    public $limit = 50;
    /**
     * @inheritdoc
     */
    public $minInput = 2;
    public $showDefaults = true;

    /**
     * @var Entite
     */
    public $entite;

    public $entiteID;

    public function init()
    {
        $this->entite = Entite::findOne(["id" => $this->entiteID]);
        if ($this->entite) {
            if ($this->showDefaults) {
                $this->defaultResults = $this->findDefaults();
            }
            $this->url = Url::to(['/cet_entite/tag/search']);
            $this->addOptions = static::canAddTag();
            parent::init();
        } else {
            print($this->entite);
        }
    }
    public function run()
    {
        if ($this->canAddTag()) {
            return parent::run();
        } else {
            return $this->emptyResult();
        }
    }
    protected function findDefaults()
    {
        return $this->entite->getEntiteTags()->all();
    }

    public static function search($term)
    {
        $instance = new static();
        $query = call_user_func([$instance->itemClass, 'find']);
        if (!empty($term)) {
            $query->andWhere(['like', 'cet_entite_tag.nom', $term]);
        }
        return static::jsonResult($query->limit($instance->limit)->all());
    }

    /**
     * @param string $term
     * @param Entite $entite
     */
    public static function searchByEntite($term, $entite)
    {
        if (!$entite) {
            return static::search($term);
        }

        $instance = new static();
        $query = $entite->getEntiteTagHasEntites();

        if (!empty($term)) {
            $query->andWhere(['like', 'cet_entite_tag.nom', $term]);
        }

        return static::jsonResult($query->all());
    }

    public static function jsonResult($tags)
    {
        $result = [];
        foreach ($tags as $tag) {
            $result[] = [
                'id' => $tag->id,
                'text' => $tag->nom
            ];
        }

        return $result;
    }

    public static function canAddTag()
    {
        return Yii::$app->user->isAdmin();
    }
    /**
     * Used to retrieve the option text of a given $item.
     *
     * @param \yii\db\ActiveRecord $item selected item
     * @return string item option text
     */
    protected function getItemText($item)
    {
        if (!($item instanceof EntiteTag)) {
            return $item;
        }

        return $item->nom;
    }

    /**
     * Used to retrieve the option image url of a given $item.
     *
     * @param \yii\db\ActiveRecord $item selected item
     * @return string|null image url or null if no selection image required.
     */
    protected function getItemImage($item)
    {
        return null;
    }
}
