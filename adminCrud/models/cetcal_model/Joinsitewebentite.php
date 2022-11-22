<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_site_web_has_cet_entite".
 *
 * @property int $cet_site_web_id
 * @property int $cet_entite_id
 *
 * @property Entite $entite
 * @property Siteweb $siteweb
 */
class Joinsitewebentite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_site_web_has_cet_entite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_site_web_id', 'cet_entite_id'], 'required'],
            [['cet_site_web_id', 'cet_entite_id'], 'integer'],
            [['cet_site_web_id', 'cet_entite_id'], 'unique', 'targetAttribute' => ['cet_site_web_id', 'cet_entite_id']],
            [['cet_entite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entite::className(), 'targetAttribute' => ['cet_entite_id' => 'id']],
            [['cet_site_web_id'], 'exist', 'skipOnError' => true, 'targetClass' => Siteweb::className(), 'targetAttribute' => ['cet_site_web_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cet_site_web_id' => 'Cet Site Web ID',
            'cet_entite_id' => 'Cet Entite ID',
        ];
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

    /**
     * Gets query for [[Siteweb]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiteweb()
    {
        return $this->hasOne(Siteweb::className(), ['id' => 'cet_site_web_id']);
    }
}
