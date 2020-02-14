<?php

namespace frontend\modules\titlequeue\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TitleQueue;

/**
 * TitlequeueSearch represents the model behind the search form of `common\models\TitleQueue`.
 */
class TitlequeueSearch extends TitleQueue
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'source_id', 'destination_id'], 'integer'],
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
        $query = TitleQueue::find();

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
            'source_id' => $this->source_id,
            'destination_id' => $this->destination_id,
        ]);

        return $dataProvider;
    }
}
