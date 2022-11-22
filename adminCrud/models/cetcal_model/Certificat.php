<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_certificat".
 *
 * @property int $id
 * @property int $pk_cet_entite
 * @property string|null $organisme
 * @property string|null $etatCertification
 * @property string|null $dateSuspension
 * @property string|null $dateArret
 * @property string|null $dateEngagement
 * @property string|null $dateNotification
 * @property string|null $url
 *
 * @property Entite $pkCetEntite
 */
class Certificat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_certificat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pk_cet_entite'], 'required'],
            [['pk_cet_entite'], 'integer'],
            [['organisme', 'etatCertification', 'dateSuspension', 'dateArret', 'dateEngagement', 'dateNotification'], 'string', 'max' => 512],
            [['url'], 'string', 'max' => 512],
            [['pk_cet_entite'], 'exist', 'skipOnError' => true, 'targetClass' => Entite::className(), 'targetAttribute' => ['pk_cet_entite' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pk_cet_entite' => 'Pk Cet Entite',
            'organisme' => 'Organisme',
            'etatCertification' => 'Etat Certification',
            'dateSuspension' => 'Date Suspension',
            'dateArret' => 'Date Arret',
            'dateEngagement' => 'Date Engagement',
            'dateNotification' => 'Date Notification',
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[PkCetEntite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPkCetEntite()
    {
        return $this->hasOne(Entite::className(), ['id' => 'pk_cet_entite']);
    }
}
