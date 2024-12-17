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
 * @property int|null $parent_id
 *
 * @property Answers[] $answers
 * @property Posts $post
 * @property Users $user
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
            [['created_at', 'parent_id'], 'safe'],
            [['posts_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::class, 'targetAttribute' => ['posts_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['users_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::class, 'targetAttribute' => ['parent_id' => 'id']],
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
            'parent_id' => 'Ответ на комментарий'
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id'])
            ->select([
                self::tableName() . '.id', 'parent_id', 'comment', 'login as author', 'url as avatarUrl', 'created_at'
            ])
            ->joinWith('user.avatar', false)
            ->orderBy(['created_at' => SORT_DESC])
        ;
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::class, ['id' => 'posts_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
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

    public function createAnswerComment($commentId, $postId)
    {
        if ($this->validate()) {
            $this->parent_id = $commentId;
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
            ->joinWith('user', false)
            ->with('answers')
            ->where(['posts_id' => $postId, 'parent_id' => null])
            ->orderBy(['created_at' => SORT_DESC])
        ;

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    public static function getComment($id)
    {
        return self::find()
            ->select([
                self::tableName() . '.id', 'comment', 'created_at', self::tableName() . '.users_id', 'login as author', 'url as avatarUrl'
            ])
            ->joinWith('user', false)
            ->with('answers')
            ->where([self::tableName() . '.id' => $id])
            ->one()
        ;
    }
}
