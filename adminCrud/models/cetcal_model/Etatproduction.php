<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_etat_production".
 *
 * @property int $id
 * @property string|null $etatProduction
 *
 * @property Joinetatproductionproduction[] $joinetatproductionproductions
 * @property Production[] $productions
 */
class Etatproduction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_etat_production';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['etatProduction'], 'string', 'max' => 512],
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
            'etatProduction' => 'Etat Production',
        ];
    }

    /**
     * Gets query for [[Joinetatproductionproductions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoinetatproductionproductions()
    {
        return $this->hasMany(Joinetatproductionproduction::className(), ['cet_etat_production_id' => 'id']);
    }

    /**
     * Gets query for [[Productions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductions()
    {
        return $this->hasMany(Production::className(), ['id' => 'cet_production_id'])->viaTable('cet_etat_production_has_cet_production', ['cet_etat_production_id' => 'id']);
    }
}
