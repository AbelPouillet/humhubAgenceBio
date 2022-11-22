<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_activite_has_cet_entite".
 *
 * @property int $cet_activite_id
 * @property int $cet_entite_id
 *
 * @property Activite $activite
 * @property Entite $entite
 */
class Joinactiviteentite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_activite_has_cet_entite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_activite_id', 'cet_entite_id'], 'required'],
            [['cet_activite_id', 'cet_entite_id'], 'integer'],
            [['cet_activite_id', 'cet_entite_id'], 'unique', 'targetAttribute' => ['cet_activite_id', 'cet_entite_id']],
            [['cet_activite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activite::className(), 'targetAttribute' => ['cet_activite_id' => 'id']],
            [['cet_entite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entite::className(), 'targetAttribute' => ['cet_entite_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cet_activite_id' => 'Cet Activite ID',
            'cet_entite_id' => 'Cet Entite ID',
        ];
    }

    /**
     * Gets query for [[Activite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivite()
    {
        return $this->hasOne(Activite::className(), ['id' => 'cet_activite_id']);
    }

    /**
     * Gets query for [[Entite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntite()
    {
        return $this->hasOne(Entite::className(), ['id' => 'cet_entite_id']);
    }
}
