<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_adresse_operateur_has_cet_entite".
 *
 * @property int $cet_adresse_operateur_id
 * @property int $cet_entite_id
 *
 * @property Adresse $adresse
 * @property Entite $entite
 */
class Joinadresseentite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_adresse_operateur_has_cet_entite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_adresse_operateur_id', 'cet_entite_id'], 'required'],
            [['cet_adresse_operateur_id', 'cet_entite_id'], 'integer'],
            [['cet_adresse_operateur_id', 'cet_entite_id'], 'unique', 'targetAttribute' => ['cet_adresse_operateur_id', 'cet_entite_id']],
            [['cet_adresse_operateur_id'], 'exist', 'skipOnError' => true, 'targetClass' => Adresse::className(), 'targetAttribute' => ['cet_adresse_operateur_id' => 'id']],
            [['cet_entite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entite::className(), 'targetAttribute' => ['cet_entite_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cet_adresse_operateur_id' => 'Cet Adresse Operateur ID',
            'cet_entite_id' => 'Cet Entite ID',
        ];
    }

    /**
     * Gets query for [[Adresse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdresse()
    {
        return $this->hasOne(Adresse::className(), ['id' => 'cet_adresse_operateur_id']);
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
