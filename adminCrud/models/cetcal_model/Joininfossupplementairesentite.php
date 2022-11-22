<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_infos_supplementaires_has_cet_entite".
 *
 * @property int $cet_infos_supplementaires_id
 * @property int $cet_entite_id
 *
 * @property Entite $entite
 * @property Infossupplementaires $infossupplementaires
 */
class Joininfossupplementairesentite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_infos_supplementaires_has_cet_entite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_infos_supplementaires_id', 'cet_entite_id'], 'required'],
            [['cet_infos_supplementaires_id', 'cet_entite_id'], 'integer'],
            [['cet_infos_supplementaires_id', 'cet_entite_id'], 'unique', 'targetAttribute' => ['cet_infos_supplementaires_id', 'cet_entite_id']],
            [['cet_entite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entite::className(), 'targetAttribute' => ['cet_entite_id' => 'id']],
            [['cet_infos_supplementaires_id'], 'exist', 'skipOnError' => true, 'targetClass' => Infossupplementaires::className(), 'targetAttribute' => ['cet_infos_supplementaires_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cet_infos_supplementaires_id' => 'Cet Infos Supplementaires ID',
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
     * Gets query for [[Infossupplementaires]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInfossupplementaires()
    {
        return $this->hasOne(Infossupplementaires::className(), ['id' => 'cet_infos_supplementaires_id']);
    }
}
