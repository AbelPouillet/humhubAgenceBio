<?php

namespace app\models\search_model;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cetcal_model\Adresse;

/**
 * AdresseSearch represents the model behind the search form of `app\models\cetcal_model\Adresse`.
 */
class AdresseSearch extends Adresse
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'departementId'], 'integer'],
            [['lieu', 'codePostal', 'ville', 'codeCommune'], 'safe'],
            [['lat', 'long'], 'number'],
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
        $query = Adresse::find();

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
            'lat' => $this->lat,
            'long' => $this->long,
            'active' => $this->active,
            'departementId' => $this->departementId,
        ]);

        $query->andFilterWhere(['like', 'lieu', $this->lieu])
            ->andFilterWhere(['like', 'codePostal', $this->codePostal])
            ->andFilterWhere(['like', 'ville', $this->ville])
            ->andFilterWhere(['like', 'codeCommune', $this->codeCommune]);

        return $dataProvider;
    }
}
