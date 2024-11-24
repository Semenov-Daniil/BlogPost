<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "bp_comments".
 *
 * @property int $id
 * @property int $posts_id
 * @property int $users_id
 * @property string $comment
 * @property string $created_at
 *
 * @property Answers[] $answers
 * @property Posts $posts
 * @property Users $users
 */
class Comments extends \yii\db\ActiveRecord
{
    public string $author = '';
    public string|null $avatarUrl = '';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['posts_id', 'users_id'], 'integer'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
            [['posts_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::class, 'targetAttribute' => ['posts_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'posts_id' => 'Пост',
            'users_id' => 'Пользователь',
            'comment' => 'Комментарий',
            'created_at' => 'Дата и время создания',
        ];
    }

    /**
     * Gets query for [[AnswersComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(AnswersComments::class, ['comments_id' => 'id'])
            ->select([
                AnswersComments::tableName() . '.id', 'comments_id', 'answer as comment', 'login as author', 'url as avatarUrl', 'created_at'
            ])
            ->joinWith('users.avatar', false)
            ->orderBy(['created_at' => SORT_ASC]);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasOne(Posts::class, ['id' => 'posts_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id'])
            ->select([
                Users::tableName() . '.id', 'login', 'url as avatarUrl'  
            ])
            ->joinWith('avatar', false);
    }

    public function createComment($postId)
    {
        if ($this->validate()) {
            $this->posts_id = $postId;
            $this->users_id = Yii::$app->user->id;
            return $this->save();
        }

        return false;
    }

    public static function getComments($postId)
    {
        $query = self::find()
            ->select([
                self::tableName() . '.id', 'comment', 'created_at', self::tableName() . '.users_id', 'login as author', 'url as avatarUrl'
            ])
            ->joinWith('users', false)
            ->with('answers')
            ->where(['posts_id' => $postId])
            ->orderBy(['created_at' => SORT_DESC])
        ;

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}
