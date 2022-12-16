<?php

namespace humhub\modules\cet_site_web\models;

use humhub\modules\cet_entite\models\Entite;
use humhub\modules\cet_join_site_web_entite\models\Joinsitewebentite;
use humhub\modules\cet_join_type_site_web_site_web\models\Jointypesitewebsiteweb;
use humhub\modules\cet_type_site_web\models\Typesiteweb;
use Yii;

/**
 * This is the model class for table "cet_site_web".
 *
 * @property int $id
 * @property string|null $url
 * @property bool|null $active
 * @property int|null $operateurId
 * @property int|null $typeSiteWebId
 *
 * @property Entite[] $entites
 * @property Joinsitewebentite[] $joinsitewebentites
 * @property Jointypesitewebsiteweb[] $jointypesitewebsitewebs
 * @property Typesiteweb[] $typesitewebs
 */
class Siteweb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_site_web';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'operateurId', 'typeSiteWebId'], 'integer'],
            [['active'], 'boolean'],
            [['url'], 'string', 'max' => 512],
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
            'url' => 'Url',
            'active' => 'Active',
            'operateurId' => 'Operateur ID',
            'typeSiteWebId' => 'Type Site Web ID',
        ];
    }

    /**
     * Gets query for [[Entites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntites()
    {
        return $this->hasMany(Entite::className(), ['id' => 'cet_entite_id'])->viaTable('cet_site_web_has_cet_entite', ['cet_site_web_id' => 'id']);
    }

    /**
     * Gets query for [[Joinsitewebentites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJoinsitewebentites()
    {
        return $this->hasMany(Joinsitewebentite::className(), ['cet_site_web_id' => 'id']);
    }

    /**
     * Gets query for [[Jointypesitewebsitewebs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJointypesitewebsitewebs()
    {
        return $this->hasMany(Jointypesitewebsiteweb::className(), ['cet_site_web_id' => 'id']);
    }

    /**
     * Gets query for [[Typesitewebs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypesitewebs()
    {
        return $this->hasMany(Typesiteweb::className(), ['id' => 'cet_type_site_web_id'])->viaTable('cet_type_site_web_has_cet_site_web', ['cet_site_web_id' => 'id']);
    }
    public function getTypesitewebsStr(){
        $typesSTR = "";
        foreach ($this->typesitewebs as $type){
            $typesSTR .= $type->nom." ";
        }
        return $typesSTR;
    }
}
