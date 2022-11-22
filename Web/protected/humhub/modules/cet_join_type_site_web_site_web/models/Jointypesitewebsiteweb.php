<?php

namespace humhub\modules\cet_join_type_site_web_site_web\models;

use humhub\modules\cet_site_web\models\Siteweb;
use humhub\modules\cet_type_site_web\models\Typesiteweb;
use Yii;

/**
 * This is the model class for table "cet_type_site_web_has_cet_site_web".
 *
 * @property int $cet_type_site_web_id
 * @property int $cet_site_web_id
 *
 * @property SiteWeb $siteweb
 * @property TypeSiteWeb $typesiteweb
 */
class Jointypesitewebsiteweb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_type_site_web_has_cet_site_web';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_type_site_web_id', 'cet_site_web_id'], 'required'],
            [['cet_type_site_web_id', 'cet_site_web_id'], 'integer'],
            [['cet_type_site_web_id', 'cet_site_web_id'], 'unique', 'targetAttribute' => ['cet_type_site_web_id', 'cet_site_web_id']],
            [['cet_site_web_id'], 'exist', 'skipOnError' => true, 'targetClass' => Siteweb::className(), 'targetAttribute' => ['cet_site_web_id' => 'id']],
            [['cet_type_site_web_id'], 'exist', 'skipOnError' => true, 'targetClass' => Typesiteweb::className(), 'targetAttribute' => ['cet_type_site_web_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cet_type_site_web_id' => 'Cet Type Site Web ID',
            'cet_site_web_id' => 'Cet Site Web ID',
        ];
    }

    /**
     * Gets query for [[Siteweb]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiteweb()
    {
        return $this->hasOne(Siteweb::className(), ['id' => 'cet_site_web_id']);
    }

    /**
     * Gets query for [[Typesiteweb]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypesiteweb()
    {
        return $this->hasOne(Typesiteweb::className(), ['id' => 'cet_type_site_web_id']);
    }
}
