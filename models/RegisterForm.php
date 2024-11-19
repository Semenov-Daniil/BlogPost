<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegisterForm is the model behind the register form.
 */
class RegisterForm extends Model
{
    public string $name = '';
    public string $surname = '';
    public string|null $patronymic = '';
    public string $login = '';
    public string $email = '';
    public string $password = '';
    public string $password_repeat = '';
    public string $phone = '';
    public bool $rules = false;
    public $uploadFile = null;
    public string $urlFile = '';

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
            if (is_null($this->uploadFile) || $this->upload()) {
                $user = new Users();

                $user->attributes = $this->attributes;
    
                if ($user->save()) {
                    if ($this->urlFile) {
                        $avatar = new Avatars();
                        $avatar->url = $this->urlFile;
                        $avatar->users_id = $user->id;
                        $avatar->save(false);
                    }

                    return Yii::$app->user->login($user);
                }
    
                $this->addErrors($user->errors);
            }
        }
        return false;
    }

    public function upload()
    {
        if (!is_dir(Yii::getAlias('@avatars'))) {
            mkdir(Yii::getAlias('@avatars'), 0755, true);
        }

        $this->urlFile = Yii::getAlias('@avatars') . '/' . Yii::$app->security->generateRandomString() . '_' . time() . '.' . $this->uploadFile->extension;
        return $this->uploadFile->saveAs($this->urlFile);
    }
}
