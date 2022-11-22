<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_production_has_cet_entite".
 *
 * @property int $cet_production_id
 * @property int $cet_entite_id
 *
 * @property Entite $entite
 * @property Production $production
 */
class Joinproductionentite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_production_has_cet_entite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_production_id', 'cet_entite_id'], 'required'],
            [['cet_production_id', 'cet_entite_id'], 'integer'],
            [['cet_production_id', 'cet_entite_id'], 'unique', 'targetAttribute' => ['cet_production_id', 'cet_entite_id']],
            [['cet_entite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entite::className(), 'targetAttribute' => ['cet_entite_id' => 'id']],
            [['cet_production_id'], 'exist', 'skipOnError' => true, 'targetClass' => Production::className(), 'targetAttribute' => ['cet_production_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cet_production_id' => 'Cet Production ID',
            'cet_entite_id' => 'Cet Entite ID',
        ];
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
