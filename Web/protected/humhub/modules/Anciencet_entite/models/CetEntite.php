<?php

namespace humhub\modules\cet_entite\models;

use Yii;
use humhub\modules\search\interfaces\Searchable;
use humhub\modules\cet_entite\widgets\Wall;
use humhub\modules\cet_producteur_lieu\models\CetProducteurLieu;
use humhub\modules\cet_type\models\CetType;
use humhub\modules\cet_produit\models\CetProduit;
use humhub\modules\cet_join_produit\models\CetJoinProduit;
use humhub\modules\cet_join_type\models\CetJoinType;
use humhub\modules\cet_infos_producteur\models\CetInfosProducteur;

/**
 * This is the model class for table "cet_entite".
 *
 * @property string|null $name
 * @property string|null $type
 * @property string|null $street
 * @property string|null $zip
 * @property string|null $city
 * @property string|null $country
 * @property string|null $state
 * @property string|null $latitude
 * @property string|null $longitude
 * @property int|null $pk
 * @property int $id
 * @property bool|null $isActive
 * @property string|null $telFixe
 * @property string|null $telMobile
 * @property string|null $email
 * @property string|null $contactPrenom
 * @property string|null $contactNom
 * @property string|null $siret
 * @property string|null $urlWeb
 * @property string|null $urlFb
 * @property string|null $urlIg
 * @property string|null $urlTwitter
 * @property string|null $urlBoutique
 * @property string|null $commentaire
 *
 * @property CetInfosProducteur $pk0
 * @property CetInfosProducteur[] $cetInfosProducteurs
 * @property CetJoinProduit[] $cetJoinProduits
 * @property CetProduit[] $fkProduits
 * @property CetJoinType[] $cetJoinTypes
 * @property CetType[] $fkTypes
 * @property CetProducteurLieu[] $cetProducteurLieus
 */
class CetEntite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_entite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pk'], 'integer'],
            [['isActive'], 'boolean'],
            [['name', 'street', 'city', 'country', 'state', 'email', 'urlWeb', 'urlFb', 'urlIg', 'urlTwitter', 'urlBoutique'], 'string', 'max' => 256],
            [['type', 'zip', 'siret'], 'string', 'max' => 16],
            [['latitude', 'longitude', 'contactPrenom', 'contactNom'], 'string', 'max' => 64],
            [['telFixe', 'telMobile'], 'string', 'max' => 32],
            [['commentaire'], 'string', 'max' => 1024],
            [['pk'], 'exist', 'skipOnError' => true, 'targetClass' => CetInfosProducteur::className(), 'targetAttribute' => ['pk' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'street' => 'Street',
            'zip' => 'Zip',
            'city' => 'City',
            'country' => 'Country',
            'state' => 'State',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'pk' => 'Pk',
            'id' => 'ID',
            'isActive' => 'Is Active',
            'telFixe' => 'Tel Fixe',
            'telMobile' => 'Tel Mobile',
            'email' => 'Email',
            'contactPrenom' => 'Contact Prenom',
            'contactNom' => 'Contact Nom',
            'siret' => 'Siret',
            'urlWeb' => 'Url Web',
            'urlFb' => 'Url Fb',
            'urlIg' => 'Url Ig',
            'urlTwitter' => 'Url Twitter',
            'urlBoutique' => 'Url Boutique',
            'commentaire' => 'Commentaire',
        ];
    }

    /**
     * Gets query for [[Pk0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPk0()
    {
        return $this->hasOne(CetInfosProducteur::className(), ['id' => 'pk']);
    }

    /**
     * Gets query for [[CetInfosProducteurs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetInfosProducteurs()
    {
        return $this->hasMany(CetInfosProducteur::className(), ['Pk_adresse_cet' => 'id']);
    }

    /**
     * Gets query for [[CetJoinProduits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetJoinProduits()
    {
        return $this->hasMany(CetJoinProduit::className(), ['Fk_adresse_cet' => 'id']);
    }

    /**
     * Gets query for [[FkProduits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkProduits()
    {
        return $this->hasMany(CetProduit::className(), ['id' => 'Fk_produit'])->viaTable('cet_join_produit', ['Fk_adresse_cet' => 'id']);
    }

    /**
     * Gets query for [[CetJoinTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetJoinTypes()
    {
        return $this->hasMany(CetJoinType::className(), ['Fk_adresse_cet' => 'id']);
    }

    /**
     * Gets query for [[FkTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkTypes()
    {
        return $this->hasMany(CetType::className(), ['id' => 'Fk_type'])->viaTable('cet_join_type', ['Fk_adresse_cet' => 'id']);
    }

    /**
     * Gets query for [[CetProducteurLieus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetProducteurLieus()
    {
        return $this->hasMany(CetProducteurLieu::className(), ['Fk_lieu' => 'id']);
    }
	/**
	 *
	 * @return mixed
	 */
	function getWallOut() {
        return Wall::widget(['cet_entite' => $this]);
	}

	/**
	 *
	 * @return mixed
	 */
	function getSearchAttributes() {
        $attributes = [
            'name' => $this->name,
            'type' => $this->type,
            'city' => $this->city,
            'produits' => $this->getProduits()
        ];

        return $attributes;
	}

    function getProduits() {
        $produits = "";
        foreach ($this->fkProduits as $index=>$index) {
            if ($index == 0) {
                $produits .= $this->fkProduits[0]->nom;
            } else {
                $produits .= ", ". $this->fkProduits[$index]->nom;
            }
        }
        return $produits;
    }
}
