<?php

namespace humhub\modules\cet_join_produit\models;

use Yii;
use humhub\modules\cet_entite\models\CetEntite;
use humhub\modules\cet_produit\models\CetProduit;
/**
 * This is the model class for table "cet_join_produit".
 *
 * @property int $Fk_adresse_cet
 * @property int $Fk_produit
 *
 * @property CetEntite $fkAdresseCet
 * @property CetProduit $fkProduit
 */
class CetJoinProduit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_join_produit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Fk_adresse_cet', 'Fk_produit'], 'required'],
            [['Fk_adresse_cet', 'Fk_produit'], 'integer'],
            [['Fk_adresse_cet', 'Fk_produit'], 'unique', 'targetAttribute' => ['Fk_adresse_cet', 'Fk_produit']],
            [['Fk_adresse_cet'], 'exist', 'skipOnError' => true, 'targetClass' => CetEntite::className(), 'targetAttribute' => ['Fk_adresse_cet' => 'id']],
            [['Fk_produit'], 'exist', 'skipOnError' => true, 'targetClass' => CetProduit::className(), 'targetAttribute' => ['Fk_produit' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Fk_adresse_cet' => 'Fk Adresse Cet',
            'Fk_produit' => 'Fk Produit',
        ];
    }

    /**
     * Gets query for [[FkAdresseCet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkAdresseCet()
    {
        return $this->hasOne(CetEntite::className(), ['id' => 'Fk_adresse_cet']);
    }

    /**
     * Gets query for [[FkProduit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkProduit()
    {
        return $this->hasOne(CetProduit::className(), ['id' => 'Fk_produit']);
    }
}
