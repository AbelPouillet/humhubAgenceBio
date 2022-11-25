<?php

namespace app\models\search_model;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cetcal_model\Produitnaf;

/**
 * ProduitnafSearch represents the model behind the search form of `app\models\cetcal_model\Produitnaf`.
 */
class ProduitnafSearch extends Produitnaf
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codenaf', 'libelle'], 'safe'],
            [['cet_produit_id'], 'integer'],
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
        $query = Produitnaf::find();

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
            'cet_produit_id' => $this->cet_produit_id,
        ]);

        $query->andFilterWhere(['like', 'codenaf', $this->codenaf])
            ->andFilterWhere(['like', 'libelle', $this->libelle]);

        return $dataProvider;
    }
}
