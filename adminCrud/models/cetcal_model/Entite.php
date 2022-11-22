<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_entite".
 *
 * @property int $id
 * @property string|null $raisonSociale
 * @property string|null $denominationcourante
 * @property string|null $siret
 * @property int|null $numeroBio
 * @property string|null $telephone
 * @property string|null $email
 * @property string|null $codeNAF
 * @property string|null $gerant
 * @property string|null $dateMaj
 * @property string|null $telephoneCommerciale
 * @property string|null $reseau
 * @property string|null $mixite
 * @property string|null $provenance
 * @property bool|null $isActive
 *
 * @property Joinactiviteentite[] $joinactiviteentites
 * @property Activite[] $activites
 * @property Joinadresseentite[] $joinadresseentites
 * @property Adresse[] $adresses
 * @property Joincategorieentite[] $joincategorieentites
 * @property Categorie[] $categories
 * @property Certificat[] $certificats
 * @property Infossupplementaires[] $infossupplementaires
 * @property Joininfossupplementairesentite[] $joininfossupplementairesentites
 * @property Joinproductionentite[] $joinproductionentites
 * @property Production[] $productions
 * @property Joinsitewebentite[] $joinsitewebentites
 * @property Siteweb[] $sitewebs
 */
class Entite extends \yii\db\ActiveRecord
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
            [['id'], 'required'],
            [['id', 'numeroBio'], 'integer'],
            [['isActive'], 'boolean'],
            [['raisonSociale', 'denominationcourante'], 'string', 'max' => 512],
            [['siret', 'telephone', 'email', 'codeNAF', 'gerant', 'dateMaj', 'telephoneCommerciale', 'reseau', 'mixite', 'provenance'], 'string', 'max' => 512],
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
            'raisonSociale' => 'Raison Sociale',
            'denominationcourante' => 'Denominationcourante',
            'siret' => 'Siret',
            'numeroBio' => 'Numero Bio',
            'telephone' => 'Telephone',
            'email' => 'Email',
            'codeNAF' => 'Code Naf',
            'gerant' => 'Gerant',
            'dateMaj' => 'Date Maj',
            'telephoneCommerciale' => 'Telephone Commerciale',
            'reseau' => 'Reseau',
            'mixite' => 'Mixite',
            'provenance' => 'Provenance',
            'isActive' => 'Is Active',
        ];
    }

    /**
     * Gets query for [[Joinactiviteentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoinactiviteentites()
    {
        return $this->hasMany(Joinactiviteentite::className(), ['cet_entite_id' => 'id']);
    }

    /**
     * Gets query for [[Activites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivites()
    {
        return $this->hasMany(Activite::className(), ['id' => 'cet_activite_id'])->viaTable('cet_activite_has_cet_entite', ['cet_entite_id' => 'id']);
    }

    /**
     * Gets query for [[Joinadresseentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoinadresseentites()
    {
        return $this->hasMany(Joinadresseentite::className(), ['cet_entite_id' => 'id']);
    }

    /**
     * Gets query for [[Adresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdresses()
    {
        return $this->hasMany(Adresse::className(), ['id' => 'cet_adresse_operateur_id'])->viaTable('cet_adresse_operateur_has_cet_entite', ['cet_entite_id' => 'id']);
    }

    /**
     * Gets query for [[Joincategorieentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoincategorieentites()
    {
        return $this->hasMany(Joincategorieentite::className(), ['cet_entite_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categorie::className(), ['id' => 'cet_categorie_id'])->viaTable('cet_categorie_has_cet_entite', ['cet_entite_id' => 'id']);
    }

    /**
     * Gets query for [[Certificats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificats()
    {
        return $this->hasMany(Certificat::className(), ['pk_cet_entite' => 'id']);
    }

    /**
     * Gets query for [[Infossupplementaires]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInfossupplementaires()
    {
        return $this->hasMany(Infossupplementaires::className(), ['id' => 'cet_infos_supplementaires_id'])->viaTable('cet_infos_supplementaires_has_cet_entite', ['cet_entite_id' => 'id']);
    }

    /**
     * Gets query for [[Joininfossupplementairesentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoininfossupplementairesentites()
    {
        return $this->hasMany(Joininfossupplementairesentite::className(), ['cet_entite_id' => 'id']);
    }

    /**
     * Gets query for [[Joinproductionentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoinproductionentites()
    {
        return $this->hasMany(Joinproductionentite::className(), ['cet_entite_id' => 'id']);
    }

    /**
     * Gets query for [[Productions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductions()
    {
        return $this->hasMany(Production::className(), ['id' => 'cet_production_id'])->viaTable('cet_production_has_cet_entite', ['cet_entite_id' => 'id']);
    }

    /**
     * Gets query for [[Joinsitewebentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoinsitewebentites()
    {
        return $this->hasMany(Joinsitewebentite::className(), ['cet_entite_id' => 'id']);
    }

    /**
     * Gets query for [[Sitewebs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSitewebs()
    {
        return $this->hasMany(Siteweb::className(), ['id' => 'cet_site_web_id'])->viaTable('cet_site_web_has_cet_entite', ['cet_entite_id' => 'id']);
    }
}
