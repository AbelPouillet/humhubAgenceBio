<?php

namespace app\models\search_model;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cetcal_model\Codenaftype;

/**
 * CodenaftypeSearch represents the model behind the search form of `app\models\cetcal_model\Codenaftype`.
 */
class CodenaftypeSearch extends Codenaftype
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cet_type_id'], 'integer'],
            [['codeNaf'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Codenaftype::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cet_type_id' => $this->cet_type_id,
        ]);

        $query->andFilterWhere(['like', 'codeNaf', $this->codeNaf]);

        return $dataProvider;
    }
}
