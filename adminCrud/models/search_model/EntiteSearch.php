<?php

namespace app\models\search_model;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cetcal_model\Entite;

/**
 * EntiteSearch represents the model behind the search form of `app\models\cetcal_model\Entite`.
 */
class EntiteSearch extends Entite
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'numeroBio'], 'integer'],
            [['raisonSociale', 'denominationcourante', 'siret', 'telephone', 'email', 'codeNAF', 'gerant', 'dateMaj', 'telephoneCommerciale', 'reseau', 'mixite', 'provenance'], 'safe'],
            [['isActive'], 'boolean'],
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
        $query = Entite::find();

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
            'numeroBio' => $this->numeroBio,
            'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'raisonSociale', $this->raisonSociale])
            ->andFilterWhere(['like', 'denominationcourante', $this->denominationcourante])
            ->andFilterWhere(['like', 'siret', $this->siret])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'codeNAF', $this->codeNAF])
            ->andFilterWhere(['like', 'gerant', $this->gerant])
            ->andFilterWhere(['like', 'dateMaj', $this->dateMaj])
            ->andFilterWhere(['like', 'telephoneCommerciale', $this->telephoneCommerciale])
            ->andFilterWhere(['like', 'reseau', $this->reseau])
            ->andFilterWhere(['like', 'mixite', $this->mixite])
            ->andFilterWhere(['like', 'provenance', $this->provenance]);

        return $dataProvider;
    }
}
