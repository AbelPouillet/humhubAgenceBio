<?php

namespace humhub\modules\cet_categorie\models;

use humhub\modules\cet_entite\models\Entite;
use humhub\modules\cet_join_categorie_entite\models\Joincategorieentite;
use Yii;

/**
 * This is the model class for table "cet_categorie".
 *
 * @property int $id
 * @property string|null $nom
 *
 * @property Joincategorieentite[] $joincategorieentites
 * @property Entite[] $entites
 */
class Categorie extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_categorie';
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
     * Gets query for [[Joincategorieentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoincategorieentites()
    {
        return $this->hasMany(Joincategorieentite::className(), ['cet_categorie_id' => 'id']);
    }

    /**
     * Gets query for [[Entites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntites()
    {
        return $this->hasMany(Entite::className(), ['id' => 'cet_entite_id'])->viaTable('cet_categorie_has_cet_entite', ['cet_categorie_id' => 'id']);
    }
}
