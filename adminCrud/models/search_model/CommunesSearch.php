<?php

namespace app\models\search_model;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cetcal_model\Communes;

/**
 * CommunesSearch represents the model behind the search form of `app\models\cetcal_model\Communes`.
 */
class CommunesSearch extends Communes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['libelle', 'Latitude', 'Longitude', 'commune', 'code_postal', 'code_departement'], 'safe'],
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
        $query = Communes::find();

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
        ]);

        $query->andFilterWhere(['like', 'libelle', $this->libelle])
            ->andFilterWhere(['like', 'Latitude', $this->Latitude])
            ->andFilterWhere(['like', 'Longitude', $this->Longitude])
            ->andFilterWhere(['like', 'commune', $this->commune])
            ->andFilterWhere(['like', 'code_postal', $this->code_postal])
            ->andFilterWhere(['like', 'code_departement', $this->code_departement]);

        return $dataProvider;
    }
}
