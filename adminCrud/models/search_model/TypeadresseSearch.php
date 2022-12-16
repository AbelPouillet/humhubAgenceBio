<?php

namespace app\models\search_model;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cetcal_model\Typeadresse;

/**
 * TypeadresseSearch represents the model behind the search form of `app\models\cetcal_model\Typeadresse`.
 */
class TypeadresseSearch extends Typeadresse
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pk_cet_adresse_operateur'], 'integer'],
            [['nom'], 'safe'],
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
        $query = Typeadresse::find();

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
            'pk_cet_adresse_operateur' => $this->pk_cet_adresse_operateur,
        ]);

        $query->andFilterWhere(['like', 'nom', $this->nom]);

        return $dataProvider;
    }
}
