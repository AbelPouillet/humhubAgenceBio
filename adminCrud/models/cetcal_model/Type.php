<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_type".
 *
 * @property int $id
 * @property string|null $nom
 *
 * @property Codenaftype[] $cetCodeNafTypes
 * @property Joinentitetype[] $cetEntiteHasCetTypes
 * @property Entite[] $cetEntites
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['nom'], 'string', 'max' => 512],
            [['id'], 'unique'],
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
     * Gets query for [[CetCodeNafTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetCodeNafTypes()
    {
        return $this->hasMany(Codenaftype::class, ['cet_type_id' => 'id']);
    }

    /**
     * Gets query for [[CetEntiteHasCetTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetEntiteHasCetTypes()
    {
        return $this->hasMany(Joinentitetype::class, ['cet_type_id' => 'id']);
    }

    /**
     * Gets query for [[CetEntites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetEntites()
    {
        return $this->hasMany(Entite::class, ['id' => 'cet_entite_id'])->viaTable('cet_entite_has_cet_type', ['cet_type_id' => 'id']);
    }
}
