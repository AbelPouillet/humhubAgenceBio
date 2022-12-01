<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_entite_has_cet_type".
 *
 * @property int $cet_entite_id
 * @property int $cet_type_id
 * @property bool|null $isDefault
 *
 * @property Entite $cetEntite
 * @property Type $cetType
 */
class Joinentitetype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_entite_has_cet_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_entite_id', 'cet_type_id'], 'required'],
            [['cet_entite_id', 'cet_type_id'], 'integer'],
            [['isDefault'], 'boolean'],
            [['cet_entite_id', 'cet_type_id'], 'unique', 'targetAttribute' => ['cet_entite_id', 'cet_type_id']],
            [['cet_entite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entite::class, 'targetAttribute' => ['cet_entite_id' => 'id']],
            [['cet_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::class, 'targetAttribute' => ['cet_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cet_entite_id' => 'Cet Entite ID',
            'cet_type_id' => 'Cet Type ID',
            'isDefault' => 'Is Default',
        ];
    }

    /**
     * Gets query for [[CetEntite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetEntite()
    {
        return $this->hasOne(Entite::class, ['id' => 'cet_entite_id']);
    }

    /**
     * Gets query for [[CetType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetType()
    {
        return $this->hasOne(Type::class, ['id' => 'cet_type_id']);
    }
}
