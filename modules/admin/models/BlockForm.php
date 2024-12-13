<?php

namespace app\modules\admin\models;

use app\models\Users;
use app\models\UsersBlocks;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read Users|null $user
 *
 */
class BlockForm extends Model
{
    public int|null $id = null;
    public string $date = '';
    public string $time = '';
    public string $comment = '';

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['date', 'time', 'comment'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d', 'min' => date('Y-m-d'), 'minString' => date('d.m.Y'), 'message' => '{attribute} должна быть в формате дд.мм.ГГГГ.'],
            [['time'], 'time'],
            ['time', 'validateTime'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Дата блокировки',
            'time' => 'Время блокировки',
            'comment' => 'Причина блокировки',
        ];
    }

    /**
     * Validates the time.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateTime($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (strtotime("$this->date $this->time") <= time()) {
                $this->addError($attribute, 'Увеличьте время или дату блокировки.');
            }
        }
    }

    public function tempBlockUser()
    {
        if ($this->validate()) {
            $blockUser = new UsersBlocks();
            $blockUser->scenario = UsersBlocks::SCENARIO_TEMP_BLOCK;

            $blockUser->users_id = $this->id;
            $blockUser->comment = $this->comment;
            $blockUser->unblocked_at = "$this->date $this->time";

            return $blockUser->save();
        }

        return false;
    }

    /**
     * Finds user by [[login]]
     *
     * @return Users|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Users::findIdentity($this->id);
        }

        return $this->_user;
    }
}
