<?php

namespace humhub\modules\cet_type\models;
use humhub\modules\cet_entite\models\CetEntite;
use humhub\modules\cet_producteur_lieu\models\CetProducteurLieu;
use humhub\modules\cet_join_type\models\CetJoinType;

use Yii;

/**
 * This is the model class for table "cet_type".
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $sous_type
 *
 * @property CetJoinType[] $cetJoinTypes
 * @property CetEntite[] $fkAdresseCets
 * @property CetProducteurLieu[] $cetProducteurLieus
 */
class CetType extends \yii\db\ActiveRecord
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
            [['type', 'sous_type'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'sous_type' => 'Sous Type',
        ];
    }

    /**
     * Gets query for [[CetJoinTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetJoinTypes()
    {
        return $this->hasMany(CetJoinType::className(), ['Fk_type' => 'id']);
    }

    /**
     * Gets query for [[FkAdresseCets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkAdresseCets()
    {
        return $this->hasMany(CetEntite::className(), ['id' => 'Fk_adresse_cet'])->viaTable('cet_join_type', ['Fk_type' => 'id']);
    }

    /**
     * Gets query for [[CetProducteurLieus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetProducteurLieus()
    {
        return $this->hasMany(CetProducteurLieu::className(), ['Fk_type' => 'id']);
    }

    public function getDisplayName(){
        return $this->type;
    }
}
