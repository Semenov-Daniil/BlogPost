<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "bp_reactions".
 *
 * @property int $id
 * @property int $reaction
 * @property int $posts_id
 * @property int $users_id
 *
 * @property Posts $posts
 * @property Users $users
 */
class Reactions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bp_reactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reaction', 'posts_id', 'users_id'], 'required'],
            [['reaction', 'posts_id', 'users_id'], 'integer'],
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
            'reaction' => 'Reaction',
            'posts_id' => 'Posts ID',
            'users_id' => 'Users ID',
        ];
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
        return $this->hasOne(Users::class, ['id' => 'users_id']);
    }

    /**
     * Get like a post.
     */
    public static function getLike($userId, $postId)
    {
        return self::find()
            ->where(['users_id' => $userId, 'posts_id' => $postId, 'reaction' => 1])
            ->exists();
    }

    /**
     * Get dislike a post.
     */
    public static function getDislike($userId, $postId)
    {
        return self::find()
            ->where(['users_id' => $userId, 'posts_id' => $postId, 'reaction' => 0])
            ->exists();
    }

    /**
     * Get reaction a post.
     */
    // public static function getDislike($userId, $postId)
    // {
    //     return self::find()
    //         ->where(['users_id' => $userId, 'posts_id' => $postId, 'reaction' => 0])
    //         ->exists();
    // }

    public static function setReactionPost($postId, $reaction)
    {
        $reactionUser = self::findOne(['users_id' => Yii::$app->user->id]) ?: new Reactions();

        if ($reactionUser->isNewRecord) {
            $reactionUser->posts_id = $postId;
            $reactionUser->users_id = Yii::$app->user->id;
            $reactionUser->reaction = $reaction;
            $reactionUser->save();
        } else {
            if ($reactionUser->reaction == $reaction) {
                $reactionUser->delete();
            } else {
                $reactionUser->reaction = $reaction;
                $reactionUser->save();
            }
        }
    }
}
