<?php

namespace app\models\cetcal_model;

use Yii;

/**
 * This is the model class for table "cet_codeNafType".
 *
 * @property int $id
 * @property int $cet_type_id
 * @property string|null $codeNaf
 *
 * @property Type $cetType
 */
class Codenaftype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cet_codeNafType';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cet_type_id'], 'required'],
            [['id', 'cet_type_id'], 'integer'],
            [['codeNaf'], 'string', 'max' => 512],
            [['id', 'cet_type_id'], 'unique', 'targetAttribute' => ['id', 'cet_type_id']],
            [['cet_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::class, 'targetAttribute' => ['cet_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cet_type_id' => 'Cet Type ID',
            'codeNaf' => 'Code Naf',
        ];
    }

    /**
     * Gets query for [[CetType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCetType()
    {
        return $this->hasOne(Type::class, ['id' => 'cet_type_id']);
    }
}
