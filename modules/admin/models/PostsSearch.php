<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Posts;
use app\models\Statuses;
use app\models\Themes;

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
                Posts::tableName() . '.id', 
                Posts::tableName() . '.title', 
                'preview', 
                'text', 
                Themes::tableName() . '.title as theme',
                Posts::tableName() . '.users_id',
                'login as author', 
                'themes_id',
                Statuses::tableName() . '.title as status',
                'statuses_id',
                'created_at',
                'updated_at',
                'path_image as pathFile',
            ])
            ->joinWith('users', false)
            ->joinWith('statuses', false)
            ->joinWith('themes', false)
            ->joinWith('postImage', false)
            ->where(['statuses_id' => Statuses::getStatus('На модерации')])
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
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
            'users_id' => $this->users_id,
            'themes_id' => $this->themes_id,
            'statuses_id' => $this->statuses_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'preview', $this->preview])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
