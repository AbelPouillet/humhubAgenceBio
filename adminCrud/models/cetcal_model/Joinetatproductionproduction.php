<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_etat_production_has_cet_production".
 *
 * @property int $cet_etat_production_id
 * @property int $cet_production_id
 *
 * @property Etatproduction $etatproduction
 * @property Production $production
 */
class Joinetatproductionproduction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_etat_production_has_cet_production';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_etat_production_id', 'cet_production_id'], 'required'],
            [['cet_etat_production_id', 'cet_production_id'], 'integer'],
            [['cet_etat_production_id', 'cet_production_id'], 'unique', 'targetAttribute' => ['cet_etat_production_id', 'cet_production_id']],
            [['cet_etat_production_id'], 'exist', 'skipOnError' => true, 'targetClass' => Etatproduction::className(), 'targetAttribute' => ['cet_etat_production_id' => 'id']],
            [['cet_production_id'], 'exist', 'skipOnError' => true, 'targetClass' => Production::className(), 'targetAttribute' => ['cet_production_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cet_etat_production_id' => 'Cet Etat Production ID',
            'cet_production_id' => 'Cet Production ID',
        ];
    }

    /**
     * Gets query for [[Etatproduction]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEtatproduction()
    {
        return $this->hasOne(Etatproduction::className(), ['id' => 'cet_etat_production_id']);
    }

    /**
     * Gets query for [[Production]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduction()
    {
        return $this->hasOne(Production::className(), ['id' => 'cet_production_id']);
    }
}
