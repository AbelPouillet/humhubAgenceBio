<?php

namespace humhub\modules\cet_production\models;

use humhub\modules\cet_entite\models\Entite;
use humhub\modules\cet_etat_production\models\Etatproduction;
use humhub\modules\cet_join_etat_production_production\models\Joinetatproductionproduction;
use humhub\modules\cet_join_production_entite\models\Joinproductionentite;
use Yii;

/**
 * This is the model class for table "cet_production".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $nom
 *
 * @property Entite[] $entites
 * @property Joinetatproductionproduction[] $joinetatproductionproductions
 * @property Etatproduction[] $etatproductions
 * @property Joinproductionentite[] $joinproductionentites
 */
class Production extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_production';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['code'], 'string', 'max' => 512],
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
            'code' => 'Code',
            'nom' => 'Nom',
        ];
    }

    /**
     * Gets query for [[Entites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntites()
    {
        return $this->hasMany(Entite::className(), ['id' => 'cet_entite_id'])->viaTable('cet_production_has_cet_entite', ['cet_production_id' => 'id']);
    }

    /**
     * Gets query for [[Joinetatproductionproductions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoinetatproductionproductions()
    {
        return $this->hasMany(Joinetatproductionproduction::className(), ['cet_production_id' => 'id']);
    }

    /**
     * Gets query for [[Etatproductions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEtatproductions()
    {
        return $this->hasMany(Etatproduction::className(), ['id' => 'cet_etat_production_id'])->viaTable('cet_etat_production_has_cet_production', ['cet_production_id' => 'id']);
    }

    /**
     * Gets query for [[Joinproductionentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoinproductionentites()
    {
        return $this->hasMany(Joinproductionentite::className(), ['cet_production_id' => 'id']);
    }
}
