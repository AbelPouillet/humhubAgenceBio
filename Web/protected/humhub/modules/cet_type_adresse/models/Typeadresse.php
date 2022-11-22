<?php

namespace humhub\modules\cet_type_adresse\models;

use humhub\modules\cet_adresse\models\Adresse;
use Yii;

/**
 * This is the model class for table "cet_type_adresse_operateur".
 *
 * @property int $pk_cet_adresse_operateur
 * @property string|null $nom
 *
 * @property Adresse $pkAdresse
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
            [['pk_cet_adresse_operateur'], 'exist', 'skipOnError' => true, 'targetClass' => Adresse::className(), 'targetAttribute' => ['pk_cet_adresse_operateur' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pk_cet_adresse_operateur' => 'Pk Cet Adresse Operateur',
            'nom' => 'Nom',
        ];
    }

    /**
     * Gets query for [[PkAdresse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPkAdresse()
    {
        return $this->hasOne(Adresse::className(), ['id' => 'pk_cet_adresse_operateur']);
    }
}
