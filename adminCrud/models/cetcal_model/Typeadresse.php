<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_type_adresse_operateur".
 *
 * @property int $id
 * @property int $pk_cet_adresse_operateur
 * @property string|null $nom
 *
 * @property Adresse $pkCetAdresseOperateur
 */
class Typeadresse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_type_adresse_operateur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pk_cet_adresse_operateur'], 'required'],
            [['pk_cet_adresse_operateur'], 'integer'],
            [['nom'], 'string', 'max' => 512],
            [['pk_cet_adresse_operateur'], 'exist', 'skipOnError' => true, 'targetClass' => Adresse::class, 'targetAttribute' => ['pk_cet_adresse_operateur' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pk_cet_adresse_operateur' => 'Pk Cet Adresse Operateur',
            'nom' => 'Nom',
        ];
    }

    /**
     * Gets query for [[PkCetAdresseOperateur]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPkCetAdresseOperateur()
    {
        return $this->hasOne(Adresse::class, ['id' => 'pk_cet_adresse_operateur']);
    }
}
