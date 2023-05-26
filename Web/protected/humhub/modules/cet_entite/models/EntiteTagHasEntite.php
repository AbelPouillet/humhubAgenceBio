<?php

namespace humhub\modules\cet_entite\models;

use Yii;

/**
 * This is the model class for table "cet_entite_tag_has_cet_entite".
 *
 * @property int $cet_entite_tag_id
 * @property int $cet_entite_id
 *
 * @property Entite $cetEntite
 * @property EntiteTag $cetEntiteTag
 */
class EntiteTagHasEntite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_entite_tag_has_cet_entite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_entite_tag_id', 'cet_entite_id'], 'required'],
            [['cet_entite_tag_id', 'cet_entite_id'], 'integer'],
            [['cet_entite_tag_id', 'cet_entite_id'], 'unique', 'targetAttribute' => ['cet_entite_tag_id', 'cet_entite_id']],
            [['cet_entite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entite::class, 'targetAttribute' => ['cet_entite_id' => 'id']],
            [['cet_entite_tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => EntiteTag::class, 'targetAttribute' => ['cet_entite_tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cet_entite_tag_id' => ' Entite Tag ID',
            'cet_entite_id' => ' Entite ID',
        ];
    }

    /**
     * Gets query for [[Entite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntite()
    {
        return $this->hasOne(Entite::class, ['id' => 'cet_entite_id']);
    }

    /**
     * Gets query for [[EntiteTag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntiteTag()
    {
        return $this->hasOne(EntiteTag::class, ['id' => 'cet_entite_tag_id']);
    }
}
