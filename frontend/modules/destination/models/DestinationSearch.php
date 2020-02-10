<?php

namespace frontend\modules\destination\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Destination;

/**
 * DestinationSearch represents the model behind the search form of `common\models\Destination`.
 */
class DestinationSearch extends Destination
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'theme_id', 'user_id'], 'integer'],
            [['domain'], 'safe'],
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
        $query = Destination::find();

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
            'theme_id' => $this->theme_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'domain', $this->domain]);

        return $dataProvider;
    }
}
