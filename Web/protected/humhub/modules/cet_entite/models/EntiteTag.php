<?php

namespace humhub\modules\cet_entite\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "cet_entite_tag".
 *
 * @property int $id
 * @property string|null $nom
 *
 * @property EntiteTagHasEntite[] $cetEntiteTagHasEntites
 * @property Entite[] $cetEntites
 */
class EntiteTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_entite_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nom' => 'Nom',
        ];
    }

    /**
     * Gets query for [[EntiteTagHasEntites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntiteTagHasEntites()
    {
        return $this->hasMany(EntiteTagHasEntite::class, ['cet_entite_tag_id' => 'id']);
    }

    /**
     * Gets query for [[Entites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntites()
    {
        return $this->hasMany(Entite::class, ['id' => 'cet_entite_id'])->viaTable('cet_entite_tag_has_cet_entite', ['cet_entite_tag_id' => 'id']);
    }
    /**
     * Return les EntiteTags pour l' Entite donnée
     * @param Entite $entite
     * @return EntiteTag[]
     */
    public function getByEntite($entite)
    {
        return $entite->getEntiteTags()->all();
    }
    /**
     * Finds instances and filters by module_id if a static module_id is given.
     *
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {

        return parent::find()
            ->orderBy('nom ASC');
    }

    public static function attach(Entite $entite, $tags)
    {
        //print(" Se lie avec ce tableau de tag :". var_dump($tags));
        $result = [];
        //Nettoyage des relations
        $lienstagsentiteactuel = $entite->getEntiteTagHasEntites()->all();
        foreach ($lienstagsentiteactuel as $lien) {
            $lien->delete();
        }
        $canAdd = Yii::$app->user->isAdmin();
        if (empty($tags)) {
            return;
        }
        $tags = is_array($tags) ? $tags : [$tags];
        foreach ($tags as $tag) {
            if (is_string($tag) && strpos($tag, '_add:') === 0 && $canAdd) {
                $newentitetag = new EntiteTag([
                    "nom" => substr($tag, strlen('_add:')),
                ]);
                if ($newentitetag->save()) {
                    $result[] = $newentitetag;
                }
            } elseif (is_numeric($tag)) {
                $tag = EntiteTag::findOne(['id' => (int) $tag]);
                if ($tag) {
                    $result[] = $tag;
                }
            } elseif ($tag instanceof EntiteTag) {
                $result[] = $tag;
            }
        }
        foreach ($result as $tag) {
            $newlinkTag = new EntiteTagHasEntite([
                "cet_entite_tag_id" => $tag->id,
                "cet_entite_id" => $entite->id
            ]);
            $newlinkTag->save();
        }
    }
}
