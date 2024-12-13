<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "bp_users_blocks".
 *
 * @property int $id
 * @property int $users_id
 * @property string $blocked_at
 * @property string|null $unblocked_at
 * @property string $comment
 *
 * @property Users $users
 */
class UsersBlocks extends ActiveRecord
{
    const SCENARIO_TEMP_BLOCK = 'template_block';
    const SCENARIO_PERM_BLOCK = 'permanens_block';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['blocked_at'],
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
        return '{{%users_blocks}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'unblocked_at', 'comment'], 'required', 'on' => self::SCENARIO_TEMP_BLOCK],
            [['users_id', 'comment'], 'required', 'on' => self::SCENARIO_PERM_BLOCK],
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
            'users_id' => 'Пользователь',
            'blocked_at' => 'Заблогирован в',
            'unblocked_at' => 'Заблокирован до',
            'comment' => 'Причина блокировки',
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
