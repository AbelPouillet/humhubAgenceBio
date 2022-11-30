<?php

namespace humhub\modules\cet_produitnaf\models;

use humhub\modules\cet_produit\models\Produit;
use Yii;

/**
 * This is the model class for table "cet_naf_produit".
 *
 * @property string|null $codenaf
 * @property string|null $libelle
 * @property int $cet_produit_id
 *
 * @property Produit $cetProduit
 */
class Produitnaf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_naf_produit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_produit_id'], 'required'],
            [['cet_produit_id'], 'integer'],
            [['codenaf'], 'string', 'max' => 16],
            [['libelle'], 'string', 'max' => 512],
            [['cet_produit_id'], 'unique'],
            [['cet_produit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produit::class, 'targetAttribute' => ['cet_produit_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codenaf' => 'Codenaf',
            'libelle' => 'Libelle',
            'cet_produit_id' => 'Cet Produit ID',
        ];
    }

    /**
     * Gets query for [[CetProduit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetProduit()
    {
        return $this->hasOne(Produit::class, ['id' => 'cet_produit_id']);
    }
}
