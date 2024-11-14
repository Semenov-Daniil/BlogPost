<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bp_avatars".
 *
 * @property int $id
 * @property int $users_id
 * @property string $url
 *
 * @property Users $user
 */
class Avatars extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bp_avatars';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'url'], 'required'],
            [['users_id'], 'integer'],
            [['url'], 'string', 'max' => 255],
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
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'users_id']);
    }
}
