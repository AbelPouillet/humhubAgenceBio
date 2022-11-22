<?php

namespace humhub\modules\cet_commune\models;

use Yii;

/**
 * This is the model class for table "cet_communes".
 *
 * @property int $id
 * @property string|null $libelle
 * @property string|null $Latitude
 * @property string|null $Longitude
 * @property string|null $commune
 * @property string|null $code_postal
 * @property string|null $code_departement
 */
class CetCommune extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_communes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['libelle', 'commune'], 'string', 'max' => 256],
            [['Latitude', 'Longitude'], 'string', 'max' => 64],
            [['code_postal', 'code_departement'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'libelle' => 'Libelle',
            'Latitude' => 'Latitude',
            'Longitude' => 'Longitude',
            'commune' => 'Commune',
            'code_postal' => 'Code Postal',
            'code_departement' => 'Code Departement',
        ];
    }
    public function getDisplayName(){
        return $this->commune;
    }
}
