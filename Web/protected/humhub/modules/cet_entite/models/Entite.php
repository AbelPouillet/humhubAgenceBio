<?php

namespace humhub\modules\cet_entite\models;

use humhub\modules\cet_activite\models\Activite;
use humhub\modules\cet_adresse\models\Adresse;
use humhub\modules\cet_categorie\models\Categorie;
use humhub\modules\cet_certificat\models\Certificat;
use humhub\modules\cet_infos_supplementaires\models\Infossupplementaires;
use humhub\modules\cet_join_activite_entite\models\Joinactiviteentite;
use humhub\modules\cet_join_adresse_entite\models\Joinadresseentite;
use humhub\modules\cet_join_categorie_entite\models\Joincategorieentite;
use humhub\modules\cet_join_infos_supplementaires_entite\models\Joininfossupplementairesentite;
use humhub\modules\cet_join_production_entite\models\Joinproductionentite;
use humhub\modules\cet_join_site_web_entite\models\Joinsitewebentite;
use humhub\modules\cet_production\models\Production;
use humhub\modules\cet_produitnaf\models\Produitnaf;
use humhub\modules\cet_site_web\models\Siteweb;
use humhub\modules\search\interfaces\Searchable;
use humhub\modules\cet_entite\widgets\Wall;

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
class Entite extends \yii\db\ActiveRecord implements Searchable
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
    /**
     * @return mixed
     */
    function getWallOut()
    {
        return Wall::widget(['cet_entite' => $this]);
    }

    /**
     * @return mixed
     */
    function getSearchAttributes()
    {
        $attributes = [
            'denominationcourante' => $this->denominationcourante,
            'categories' => $this->getCategoriesStr(),
            'activites' => $this->getActivitesStr(),
            'productions' => $this->getProductionsStr(),
            'produits' => $this->getProduitsStr()
        ];

        return $attributes;
    }

    public function getProduitsStr()
    {
        $produits = "";
        foreach ($this->productions as $production) {
            $codeNafArray = explode('.', $production->code, 2);
            $codeNafNiv1 = isset($codeNafArray[0]) ? $codeNafArray[0] : '';
            $codeNafNiv2 = isset($codeNafArray[1]) ? substr($codeNafArray[1], 0, 2) : '';
            foreach (Produitnaf::find()->all() as $produitnaf) {
                if ($codeNafNiv2 != '' ?
                str_starts_with($produitnaf->codenaf, $codeNafNiv1 . '.' . $codeNafNiv2)
                : str_starts_with($produitnaf->codenaf, $codeNafNiv1)) {
                    $produits .= $produitnaf->cetProduit->nom . " , ";
                }
            }
        }
        return $produits;
    }
    public function getCategoriesStr()
    {
        $categories = "";
        foreach ($this->categories as $index => $index) {
            if ($index == 0) {
                $categories .= $this->categories[0]->nom;
            } else {
                $categories .= ", " . $this->categories[$index]->nom;
            }
        }
        return $categories;
    }
    public function getActivitesStr()
    {
        $activites = "";
        foreach ($this->activites as $index => $index) {
            if ($index == 0) {
                $activites .= $this->activites[0]->nom;
            } else {
                $activites .= ", " . $this->activites[$index]->nom;
            }
        }
        return $activites;
    }

    public function getProductionsStr()
    {
        $productions = "";
        foreach ($this->productions as $index => $index) {
            if ($index == 0) {
                $productions .= $this->productions[0]->nom;
            } else {
                $productions .= ", " . $this->productions[$index]->nom;
            }
        }
        return $productions;
    }
}
