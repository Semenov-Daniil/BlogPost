<?php

namespace app\modules\admin\models;

use app\models\Roles;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;
use app\models\UsersBlocks;
use yii\helpers\VarDumper;

/**
 * UsersSearch represents the model behind the search form of `app\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'surname', 'patronymic', 'login', 'isBlock'], 'safe'],
            [['isBlock'], 'default', 'value' => null]
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
        $subQuery = UsersBlocks::find()
            ->select([
                'users_id',
                'MAX(blocked_at) as last_blocked_at' 
            ])
            ->groupBy('users_id')
        ;

        $query = Users::find()
            ->select([
                Users::tableName() . '.id',
                'name',
                'surname',
                'patronymic',
                'login',
                'isBlock' => 'CASE 
                    WHEN 
                        users_blocks.users_id IS NOT NULL AND (users_blocks.unblocked_at IS NULL OR users_blocks.unblocked_at > NOW()) 
                    THEN 
                        1 
                    ELSE 
                        0 
                    END
                ',
            ])
            ->leftJoin(
                ['ub' => $subQuery],
                'ub.users_id = ' . Users::tableName() . '.id'
            )
            ->leftJoin(
                ['users_blocks' => UsersBlocks::tableName()],
                'users_blocks.users_id = ub.users_id AND users_blocks.blocked_at = ub.last_blocked_at'
            )
            ->where(['roles_id' => Roles::getRoles('author')])
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
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

        if (!is_null($this->isBlock) && $this->isBlock !== '') {
            if ($this->isBlock) {
                $query->andWhere('users_blocks.users_id IS NOT NULL AND (users_blocks.unblocked_at IS NULL OR users_blocks.unblocked_at > NOW())');
            } else {
                $query->andWhere('users_blocks.users_id IS NULL OR users_blocks.unblocked_at < NOW()');
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic])
            ->andFilterWhere(['like', 'login', $this->login]);

        return $dataProvider;
    }

    public static function getFilterBlocks()
    {
        return [
            0 => 'Активные',
            1 => 'Заблокированные',
        ];
    }
}
