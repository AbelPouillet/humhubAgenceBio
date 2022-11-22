<?php

namespace humhub\modules\cet_activite\models;

use humhub\modules\cet_entite\models\Entite;
use humhub\modules\cet_join_activite_entite\models\Joinactiviteentite;
use Yii;

/**
 * This is the model class for table "cet_activite".
 *
 * @property int $id
 * @property string|null $nom
 *
 * @property Joinactiviteentite[] $joinactiviteentites
 * @property Entite[] $entites
 */
class Activite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_activite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['nom'], 'string', 'max' => 256],
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
     * Gets query for [[Joinactiviteentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoinactiviteentites()
    {
        return $this->hasMany(Joinactiviteentite::className(), ['cet_activite_id' => 'id']);
    }

    /**
     * Gets query for [[Entites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntites()
    {
        return $this->hasMany(Entite::className(), ['id' => 'cet_entite_id'])->viaTable('cet_activite_has_cet_entite', ['cet_activite_id' => 'id']);
    }
}
