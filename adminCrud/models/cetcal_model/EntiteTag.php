<?php

namespace app\models\cetcal_model;

use Yii;

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
}
