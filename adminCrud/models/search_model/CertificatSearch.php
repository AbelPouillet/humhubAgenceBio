<?php

namespace app\models\search_model;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cetcal_model\Certificat;

/**
 * CertificatSearch represents the model behind the search form of `app\models\cetcal_model\Certificat`.
 */
class CertificatSearch extends Certificat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pk_cet_entite'], 'integer'],
            [['organisme', 'etatCertification', 'dateSuspension', 'dateArret', 'dateEngagement', 'dateNotification', 'url'], 'safe'],
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
        $query = Certificat::find();

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
            'pk_cet_entite' => $this->pk_cet_entite,
        ]);

        $query->andFilterWhere(['like', 'organisme', $this->organisme])
            ->andFilterWhere(['like', 'etatCertification', $this->etatCertification])
            ->andFilterWhere(['like', 'dateSuspension', $this->dateSuspension])
            ->andFilterWhere(['like', 'dateArret', $this->dateArret])
            ->andFilterWhere(['like', 'dateEngagement', $this->dateEngagement])
            ->andFilterWhere(['like', 'dateNotification', $this->dateNotification])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
