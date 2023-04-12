<?php

namespace humhub\modules\cet_adresse\models;

use humhub\modules\cet_entite\models\Entite;
use humhub\modules\cet_join_adresse_entite\models\Joinadresseentite;
use humhub\modules\cet_type_adresse\models\Typeadresse;
use Yii;

/**
 * This is the model class for table "cet_adresse_operateur".
 *
 * @property int $id
 * @property string|null $lieu
 * @property string|null $codePostal
 * @property string|null $ville
 * @property float|null $lat
 * @property float|null $long
 * @property string|null $codeCommune
 * @property bool|null $active
 * @property int|null $departementId
 *
 * @property Joinadresseentite[] $joinadresseentites
 * @property Entite[] $entites
 * @property Typeadresse[] $typeadresses
 */
class Adresse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_adresse_operateur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'departementId'], 'integer'],
            [['lat', 'long'], 'number'],
            [['active'], 'boolean'],
            [['lieu'], 'string', 'max' => 256],
            [['codePostal', 'ville', 'codeCommune'], 'string', 'max' => 512],
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
            'lieu' => 'Lieu',
            'codePostal' => 'Code Postal',
            'ville' => 'Ville',
            'lat' => 'Lat',
            'long' => 'Long',
            'codeCommune' => 'Code Commune',
            'active' => 'Active',
            'departementId' => 'Departement ID',
        ];
    }

    /**
     * Gets query for [[Joinadresseentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoinadresseentites()
    {
        return $this->hasMany(Joinadresseentite::className(), ['cet_adresse_operateur_id' => 'id']);
    }

    /**
     * Gets query for [[Entites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntites()
    {
        return $this->hasMany(Entite::className(), ['id' => 'cet_entite_id'])->viaTable('cet_adresse_operateur_has_cet_entite', ['cet_adresse_operateur_id' => 'id']);
    }

    /**
     * Gets query for [[Typeadresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypeadresses()
    {
        return $this->hasMany(Typeadresse::className(), ['pk_cet_adresse_operateur' => 'id']);
    }

    public function getTypeadressesSTR()
    {
        $types = "";
        foreach ($this->typeadresses as $index => $index) {
            if ($index == 0) {
                $types .= $this->typeadresses[0]->nom;
            } else {
                $types .= ", " . $this->typeadresses[$index]->nom;
            }
        }
        return $types;
    }

    public function getAdresseSTR(){
        return $this->lieu." ".$this->ville." ".$this->codePostal;
    }
}
