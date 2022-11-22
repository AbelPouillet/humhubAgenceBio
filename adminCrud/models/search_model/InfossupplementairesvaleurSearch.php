<?php

namespace app\models\search_model;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cetcal_model\Infossupplementairesvaleur;

/**
 * InfossupplementairesvaleurSearch represents the model behind the search form of `app\models\cetcal_model\Infossupplementairesvaleur`.
 */
class InfossupplementairesvaleurSearch extends Infossupplementairesvaleur
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pk_cet_infos_supplementaires', 'cet_entite_id'], 'integer'],
            [['valeur'], 'safe'],
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
        $query = Infossupplementairesvaleur::find();

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
            'pk_cet_infos_supplementaires' => $this->pk_cet_infos_supplementaires,
            'cet_entite_id' => $this->cet_entite_id,
        ]);

        $query->andFilterWhere(['like', 'valeur', $this->valeur]);

        return $dataProvider;
    }
}
