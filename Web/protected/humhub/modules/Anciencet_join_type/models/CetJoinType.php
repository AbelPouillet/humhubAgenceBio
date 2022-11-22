<?php

namespace humhub\modules\cet_join_type\models;

use Yii;
use humhub\modules\cet_entite\models\CetEntite;
use humhub\modules\cet_type\models\CetType;
/**
 * This is the model class for table "cet_join_type".
 *
 * @property int $Fk_adresse_cet
 * @property int $Fk_type
 *
 * @property CetEntite $fkAdresseCet
 * @property CetType $fkType
 */
class CetJoinType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_join_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Fk_adresse_cet', 'Fk_type'], 'required'],
            [['Fk_adresse_cet', 'Fk_type'], 'integer'],
            [['Fk_adresse_cet', 'Fk_type'], 'unique', 'targetAttribute' => ['Fk_adresse_cet', 'Fk_type']],
            [['Fk_adresse_cet'], 'exist', 'skipOnError' => true, 'targetClass' => CetEntite::className(), 'targetAttribute' => ['Fk_adresse_cet' => 'id']],
            [['Fk_type'], 'exist', 'skipOnError' => true, 'targetClass' => CetType::className(), 'targetAttribute' => ['Fk_type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Fk_adresse_cet' => 'Fk Adresse Cet',
            'Fk_type' => 'Fk Type',
        ];
    }

    /**
     * Gets query for [[FkAdresseCet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkAdresseCet()
    {
        return $this->hasOne(CetEntite::className(), ['id' => 'Fk_adresse_cet']);
    }

    /**
     * Gets query for [[FkType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkType()
    {
        return $this->hasOne(CetType::className(), ['id' => 'Fk_type']);
    }
}
