<?php

namespace humhub\modules\cet_infos_supplementaires_valeur\models;

use humhub\modules\cet_entite\models\Entite;
use humhub\modules\cet_infos_supplementaires\models\Infossupplementaires;
use Yii;

/**
 * This is the model class for table "cet_infos_supplementaires_valeur".
 *
 * @property int $pk_cet_infos_supplementaires
 * @property string|null $valeur
 * @property int $cet_entite_id
 *
 * @property Entite $entite
 * @property Infossupplementaires $pkInfossupplementaires
 */
class Infossupplementairesvaleur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_infos_supplementaires_valeur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pk_cet_infos_supplementaires', 'cet_entite_id'], 'required'],
            [['pk_cet_infos_supplementaires', 'cet_entite_id'], 'integer'],
            [['valeur'], 'string', 'max' => 512],
            [['cet_entite_id'], 'unique'],
            [['cet_entite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entite::className(), 'targetAttribute' => ['cet_entite_id' => 'id']],
            [['pk_cet_infos_supplementaires'], 'exist', 'skipOnError' => true, 'targetClass' => Infossupplementaires::className(), 'targetAttribute' => ['pk_cet_infos_supplementaires' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pk_cet_infos_supplementaires' => 'Pk Cet Infos Supplementaires',
            'valeur' => 'Valeur',
            'cet_entite_id' => 'Cet Entite ID',
        ];
    }

    /**
     * Gets query for [[CetEntite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetEntite()
    {
        return $this->hasOne(Entite::className(), ['id' => 'cet_entite_id']);
    }

    /**
     * Gets query for [[PkCetInfosSupplementaires]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPkCetInfosSupplementaires()
    {
        return $this->hasOne(Infossupplementaires::className(), ['id' => 'pk_cet_infos_supplementaires']);
    }
}
