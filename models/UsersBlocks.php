<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bp_users_blocks".
 *
 * @property int $id
 * @property int $users_id
 * @property string $blocked_at
 * @property string $unblocked_at
 * @property string $comment
 *
 * @property Users $users
 */
class UsersBlocks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users_blocks}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'blocked_at', 'unblocked_at'], 'required'],
            [['comment'], 'string'],
            [['users_id'], 'integer'],
            [['blocked_at', 'unblocked_at'], 'safe'],
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
            'users_id' => 'Users ID',
            'blocked_at' => 'Blocked At',
            'unblocked_at' => 'Unblocked At',
        ];
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
}
