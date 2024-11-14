<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegisterForm is the model behind the register form.
 */
class RegisterForm extends Model
{
    public string $name = 'Иван';
    public string $surname = 'Иванов';
    public string|null $patronymic = '';
    public string $login = 'user-u';
    public string $email = 'user@user.ru';
    public string $password = 'pa55WORD';
    public string $password_repeat = 'pa55WORD';
    public string $phone = '+7(999)-999-99-99';
    public bool $rules = false;
    public object|null $uploadFile = null;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'password', 'password_repeat', 'phone'], 'required'],
            [['rules'], 'required', 'requiredValue' => true, 'message' => 'Необходимо согласие с правилами регистрации.'],
            [['name', 'surname', 'patronymic', 'login', 'email', 'password_repeat'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 255, 'min' => 6],
            ['uploadFile', 'image'],
            [['login'], 'unique', 'targetClass' => Users::class],
            [['email'], 'unique', 'targetClass' => Users::class],
            [['name', 'surname', 'patronymic'], 'match', 'pattern' => '/^[а-яё\s\-]+$/ui', 'message' => 'Только кириллица, пробел, тире.'],
            [['login'], 'match', 'pattern' => '/^[a-z\-]+$/i', 'message' => 'Только латиница, тире.'],
            [['password'], 'match', 'pattern' => '/^[a-z\d]+$/i', 'message' => 'Только латиница, цифры.'],
            [['phone'], 'match', 'pattern' => '/^\+7\([\d]{3}\)\-[\d]{3}(\-[\d]{2}){2}$/i', 'message' => 'Только в формате +7(XXX)-XXX-XX-XX.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['email', 'email'],
        ];
    }

      /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'login' => 'Логин',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'phone' => 'Телефон',
            'rules' => 'Согласие с правилами регистрации',
            'uploadFile' => 'Аватар',
        ];
    }

    /**
     * Register new user.
     * @return bool the user is registered and logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new Users();

            $user->attributes = $this->attributes;

            if ($user->save()) {
                return Yii::$app->user->login($user);
            }

            $this->addErrors($user->errors);
        }
        return false;
    }
}
