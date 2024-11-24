<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "bp_answers_comments".
 *
 * @property int $id
 * @property int $users_id
 * @property int $comments_id
 * @property string $answer
 * @property string $created_at
 *
 * @property Comments $comments
 * @property Users $users
 */
class AnswersComments extends \yii\db\ActiveRecord
{
    public string $author = '';
    public string|null $avatarUrl = '';
    public string $comment = '';

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
        return '{{%answers_comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer'], 'required'],
            [['users_id', 'comments_id'], 'integer'],
            [['answer'], 'string'],
            [['created_at'], 'safe'],
            [['comments_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::class, 'targetAttribute' => ['comments_id' => 'id']],
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
            'users_id' => 'Пользователь',
            'comments_id' => 'Комментарий',
            'answer' => 'Ответ на комментарий',
            'created_at' => 'Дата и время создания',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasOne(Comments::class, ['id' => 'comments_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id']);
    }

    public function createComment($commentId)
    {
        if ($this->validate()) {
            $this->comments_id = $commentId;
            $this->users_id = Yii::$app->user->id;
            return $this->save();
        }

        return false;
    }
}
