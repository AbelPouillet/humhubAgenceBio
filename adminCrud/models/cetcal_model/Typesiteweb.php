<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_type_site_web".
 *
 * @property int $id
 * @property string|null $nom
 * @property int|null $status
 *
 * @property Siteweb[] $sitewebs
 * @property Jointypesitewebsiteweb[] $jointypesitewebsitewebs
 */
class Typesiteweb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_type_site_web';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'status'], 'integer'],
            [['nom'], 'string', 'max' => 512],
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
            'nom' => 'Nom',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Sitewebs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSitewebs()
    {
        return $this->hasMany(Siteweb::className(), ['id' => 'cet_site_web_id'])->viaTable('cet_type_site_web_has_cet_site_web', ['cet_type_site_web_id' => 'id']);
    }

    /**
     * Gets query for [[Jointypesitewebsitewebs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJointypesitewebsitewebs()
    {
        return $this->hasMany(Jointypesitewebsiteweb::className(), ['cet_type_site_web_id' => 'id']);
    }
}
