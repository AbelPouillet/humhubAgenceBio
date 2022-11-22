<?php

namespace humhub\modules\cet_infos_supplementaires\models;

use humhub\modules\cet_entite\models\Entite;
use humhub\modules\cet_infos_supplementaires_valeur\models\Infossupplementairesvaleur;
use humhub\modules\cet_join_infos_supplementaires_entite\models\Joininfossupplementairesentite;
use Yii;

/**
 * This is the model class for table "cet_infos_supplementaires".
 *
 * @property int $id
 * @property string|null $nom
 * @property string|null $label
 *
 * @property Entite[] $entites
 * @property Joininfossupplementairesentite[] $joininfossupplementairesentites
 * @property Infossupplementairesvaleur[] $infossupplementairesValeurs
 */
class Infossupplementaires extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_infos_supplementaires';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['nom', 'label'], 'string', 'max' => 512],
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
            'label' => 'Label',
        ];
    }

    /**
     * Gets query for [[Entites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntites()
    {
        return $this->hasMany(Entite::className(), ['id' => 'cet_entite_id'])->viaTable('cet_infos_supplementaires_has_cet_entite', ['cet_infos_supplementaires_id' => 'id']);
    }

    /**
     * Gets query for [[Joininfossupplementairesentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoininfossupplementairesentites()
    {
        return $this->hasMany(Joininfossupplementairesentite::className(), ['cet_infos_supplementaires_id' => 'id']);
    }

    /**
     * Gets query for [[InfossupplementairesValeurs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInfossupplementairesValeurs()
    {
        return $this->hasMany(Infossupplementairesvaleur::className(), ['pk_cet_infos_supplementaires' => 'id']);
    }
}
