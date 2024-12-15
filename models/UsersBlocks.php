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
 * @property string $blocked_blocked_comment 
 * @property string|null $pre_unblocked_at
 * @property string|null $unblocked_comment
 *
 * @property Users $users
 */
class UsersBlocks extends ActiveRecord
{
    public string $date = '';
    public string $time = '';

    const SCENARIO_TEMP_BLOCK = 'template_block';
    const SCENARIO_PERM_BLOCK = 'permanens_block';
    const SCENARIO_UNBLOCK = 'unblock';

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
            [['blocked_comment', 'unblocked_comment'], 'string'],
            [['users_id'], 'integer'],
            [['blocked_at', 'unblocked_at', 'pre_unblocked_at'], 'safe'],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['users_id' => 'id']],
            [['date'], 'date', 'format' => 'php:Y-m-d', 'min' => date('Y-m-d'), 'minString' => date('d.m.Y'), 'message' => '{attribute} должна быть в формате дд.мм.гггг.'],
            [['time'], 'time'],
            ['time', 'validateTime'],

            [['date', 'time', 'blocked_comment'], 'required', 'on' => self::SCENARIO_TEMP_BLOCK],

            [['blocked_comment'], 'required', 'on' => self::SCENARIO_PERM_BLOCK],

            [['unblocked_comment'], 'required', 'on' => self::SCENARIO_UNBLOCK],

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
            'blocked_at' => 'Заблокирован в',
            'unblocked_at' => 'Заблокирован до',
            'blocked_comment' => 'Причина блокировки',
            'unblocked_comment' => 'Причина разблокировки',
            'pre_unblocked_at' => 'Разблокирован',
            'date' => 'Дата блокировки',
            'time' => 'Время блокировки',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateTime($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (strtotime("$this->date $this->time") <= time()) {
                $this->addError($attribute, 'Увеличьте дату или время блокировки.');
            }
        }
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

    public static function findLastBlock(string $userId): static|null
    {
        return self::find()
            ->where(['users_id' => $userId])
            ->orderBy([
                'blocked_at' => SORT_DESC
            ])
            ->limit(1)
            ->one()
        ;
    }

    public function tempBlockUser($userId)
    {
        if ($this->validate()) {

            $this->users_id = $userId;
            $this->unblocked_at = "$this->date $this->time";

            return $this->save();
        }

        return false;
    }

    public function permBlockUser($userId)
    {
        if ($this->validate()) {

            $this->users_id = $userId;

            return $this->save();
        }

        return false;
    }

    public function unblockUser($userId)
    {
        if ($this->validate()) {
            $this->pre_unblocked_at = new Expression('NOW()');
            return $this->save();
        }

        return false;
    }
}
