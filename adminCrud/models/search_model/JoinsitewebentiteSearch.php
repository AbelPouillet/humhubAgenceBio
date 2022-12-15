<?php

namespace app\models\search_model;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cetcal_model\Joinsitewebentite;

/**
 * JoinsitewebentiteSearch represents the model behind the search form of `app\models\cetcal_model\Joinsitewebentite`.
 */
class JoinsitewebentiteSearch extends Joinsitewebentite
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cet_site_web_id', 'cet_entite_id'], 'integer'],
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
        $query = Joinsitewebentite::find();

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
            'cet_site_web_id' => $this->cet_site_web_id,
            'cet_entite_id' => $this->cet_entite_id,
        ]);

        return $dataProvider;
    }
}
