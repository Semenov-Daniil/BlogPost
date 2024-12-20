<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Posts;

/**
 * PostsSearch represents the model behind the search form of `app\models\Posts`.
 */
class PostsSearch extends Posts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'users_id', 'themes_id', 'statuses_id'], 'integer'],
            [['title', 'preview', 'text', 'created_at', 'updated_at'], 'safe'],
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
        $query = Posts::find()
            ->select([
                self::tableName() . '.id', 
                self::tableName() . '.title', 
                'preview', 
                'text', 
                Themes::tableName() . '.title as theme',
                'users_id',
                'login as author', 
                'statuses_id',
                'created_at',
                'updated_at',
                'path_image as pathFile',
            ])
            ->joinWith('user', false)
            ->joinWith('theme', false)
            ->joinWith('image', false)
            ->where(['statuses_id' => Statuses::getIdByTitle('Одобрен')])
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            'users_id' => $this->users_id,
            'themes_id' => $this->themes_id,
            'statuses_id' => $this->statuses_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.title', $this->title])
            ->andFilterWhere(['like', 'preview', $this->preview])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
