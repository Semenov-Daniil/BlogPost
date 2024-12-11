<?php

namespace app\modules\admin\models;

use app\models\Users;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read Users|null $user
 *
 */
class BlockForm extends Model
{
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
            [['date'], 'date', 'min' => date('Y-m-d'), 'format' => 'php:Y-m-d'],
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

    

    /**
     * Finds user by [[login]]
     *
     * @return Users|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            // $this->_user = Users::findByLogin($this->login);
        }

        return $this->_user;
    }
}
