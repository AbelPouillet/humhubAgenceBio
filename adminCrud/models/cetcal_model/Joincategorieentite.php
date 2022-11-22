<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_categorie_has_cet_entite".
 *
 * @property int $cet_categorie_id
 * @property int $cet_entite_id
 *
 * @property Categorie $categorie
 * @property Entite $entite
 */
class Joincategorieentite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_categorie_has_cet_entite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_categorie_id', 'cet_entite_id'], 'required'],
            [['cet_categorie_id', 'cet_entite_id'], 'integer'],
            [['cet_categorie_id', 'cet_entite_id'], 'unique', 'targetAttribute' => ['cet_categorie_id', 'cet_entite_id']],
            [['cet_categorie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorie::className(), 'targetAttribute' => ['cet_categorie_id' => 'id']],
            [['cet_entite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entite::className(), 'targetAttribute' => ['cet_entite_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cet_categorie_id' => 'Cet Categorie ID',
            'cet_entite_id' => 'Cet Entite ID',
        ];
    }

    /**
     * Gets query for [[Categorie]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategorie()
    {
        return $this->hasOne(Categorie::className(), ['id' => 'cet_categorie_id']);
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
