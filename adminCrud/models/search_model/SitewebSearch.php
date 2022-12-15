<?php

namespace app\models\search_model;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cetcal_model\Siteweb;

/**
 * SitewebSearch represents the model behind the search form of `app\models\cetcal_model\Siteweb`.
 */
class SitewebSearch extends Siteweb
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'operateurId', 'typeSiteWebId'], 'integer'],
            [['url'], 'safe'],
            [['active'], 'boolean'],
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
        $query = Siteweb::find();

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
            'active' => $this->active,
            'operateurId' => $this->operateurId,
            'typeSiteWebId' => $this->typeSiteWebId,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
