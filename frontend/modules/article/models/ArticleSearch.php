<?php

namespace frontend\modules\article\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Article;

/**
 * ArticleSearch represents the model behind the search form of `common\models\Article`.
 */
class ArticleSearch extends Article
{
    public $category;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'source_id', 'source_type', 'parent_id'], 'integer'],
            [['name', 'text', 'category', 'title', 'keywords', 'description', 'url', 'new_url'], 'safe'],
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
        $query = Article::find()
            ->leftJoin('article_category', 'article.id = article_category.article_id')
            ->leftJoin('destination_article', 'article.id = destination_article.article_id')
            ->leftJoin('category', 'article_category.category_id = category.id')
            ->leftJoin('destination', 'destination_article.article_id = destination.id')
            ->groupBy('article.id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
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

        $query->andFilterWhere(['like', 'article.name', $this->name])
            ->andFilterWhere(['like', 'article.source_id', $this->source_id])
            ->andFilterWhere(['like', 'article.source_type', $this->source_type])
            ->andFilterWhere(['like', 'article.text', $this->text])
            ->andFilterWhere(['like', 'article.title', $this->title])
            ->andFilterWhere(['like', 'article.description', $this->description])
            ->andFilterWhere(['like', 'article.keywords', $this->keywords])
            ->andFilterWhere(['like', 'article.url', $this->url])
            ->andFilterWhere(['like', 'article.new_url', $this->new_url])
            ->andFilterWhere(['like', 'category.name', $this->category]);

        return $dataProvider;
    }
}