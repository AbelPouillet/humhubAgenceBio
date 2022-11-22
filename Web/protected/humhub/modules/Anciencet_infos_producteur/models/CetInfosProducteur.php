<?php

namespace humhub\modules\cet_infos_producteur\models;

use Yii;
use humhub\modules\cet_entite\models\CetEntite;
use humhub\modules\cet_producteur_lieu\models\CetProducteurLieu;

/**
 * This is the model class for table "cet_infos_producteur".
 *
 * @property string|null $prod_inscrit
 * @property string|null $fournisseur_cet
 * @property int|null $niv_certif_ab
 * @property string|null $orgcertifbio
 * @property string|null $urlcertifab
 * @property string|null $surfacehectterres
 * @property string|null $surfacesousserre
 * @property string|null $tetes_betail
 * @property string|null $hl_par_an
 * @property int $id
 *
 * @property CetEntite[] $cetEntites
 * @property CetProducteurLieu[] $cetProducteurLieus
 */
class CetInfosProducteur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_infos_producteur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['niv_certif_ab'], 'integer'],
            [['prod_inscrit', 'fournisseur_cet'], 'string', 'max' => 8],
            [['orgcertifbio'], 'string', 'max' => 128],
            [['urlcertifab'], 'string', 'max' => 256],
            [['surfacehectterres', 'surfacesousserre', 'tetes_betail', 'hl_par_an'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'prod_inscrit' => 'Prod Inscrit',
            'fournisseur_cet' => 'Fournisseur Cet',
            'niv_certif_ab' => 'Niv Certif Ab',
            'orgcertifbio' => 'Orgcertifbio',
            'urlcertifab' => 'Urlcertifab',
            'surfacehectterres' => 'Surfacehectterres',
            'surfacesousserre' => 'Surfacesousserre',
            'tetes_betail' => 'Tetes Betail',
            'hl_par_an' => 'Hl Par An',
            'id' => 'ID',
        ];
    }

    /**
     * Gets query for [[CetEntites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetEntites()
    {
        return $this->hasMany(CetEntite::className(), ['pk' => 'id']);
    }

    /**
     * Gets query for [[CetProducteurLieus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetProducteurLieus()
    {
        return $this->hasMany(CetProducteurLieu::className(), ['Fk_producteur' => 'id']);
    }
}
