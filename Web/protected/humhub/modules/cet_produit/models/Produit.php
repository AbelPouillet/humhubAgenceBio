<?php

namespace humhub\modules\cet_produit\models;


use humhub\modules\cet_produitnaf\models\Produitnaf;
use Yii;

/**
 * This is the model class for table "cet_produit".
 *
 * @property int $id
 * @property string|null $categorie
 * @property string|null $nom
 *
 * @property Produitnaf $cetNafProduit
 */
class Produit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_produit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['categorie', 'nom'], 'string', 'max' => 512],
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
            'categorie' => 'Categorie',
            'nom' => 'Nom',
        ];
    }

    /**
     * Gets query for [[CetNafProduit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetNafProduit()
    {
        return $this->hasOne(Produitnaf::class, ['cet_produit_id' => 'id']);
    }
}
