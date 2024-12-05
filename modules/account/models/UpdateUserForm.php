<?php

namespace app\modules\account\models;

use app\models\Avatars;
use app\models\Users;
use Exception;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * UpdateUserForm is the model behind the update user form.
 */
class UpdateUserForm extends Model
{
    public string $name = '';
    public string $surname = '';
    public string|null $patronymic = '';
    public string $login = '';
    public string $email = '';
    public string $password = '';
    public string $password_repeat = '';
    public string $phone = '';
    public $uploadFile = null;
    public string $urlFile = '';

    private $_user = false;

    const SCENARIO_UPDATE_AVATAR = 'update-avatar';
    const SCENARIO_UPDATE_INFO = 'update-info';
    const SCENARIO_CHANGE_PASSWORD = 'change-password';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'phone', 'uploadFile', 'password', 'password_repeat'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['name', 'surname', 'patronymic', 'login', 'email', 'password_repeat'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 255, 'min' => 6],
            ['uploadFile', 'image'],
            [['login'], 'unique', 'targetClass' => Users::class, 'filter' => ['not', ['login' => Yii::$app->user->identity->login]]],
            [['email'], 'unique', 'targetClass' => Users::class, 'filter' => ['not', ['email' => Yii::$app->user->identity->email]]],
            [['name', 'surname', 'patronymic'], 'match', 'pattern' => '/^[а-яё\s\-]+$/ui', 'message' => 'Только кириллица, пробел, тире.'],
            [['login'], 'match', 'pattern' => '/^[a-z\-]+$/i', 'message' => 'Только латиница, тире.'],
            [['password'], 'match', 'pattern' => '/^[a-z\d]+$/i', 'message' => 'Только латиница, цифры.'],
            [['phone'], 'match', 'pattern' => '/^\+7\([\d]{3}\)\-[\d]{3}(\-[\d]{2}){2}$/i', 'message' => 'Только в формате +7(XXX)-XXX-XX-XX.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['email', 'email'],

            [['uploadFile'], 'required', 'on' => self::SCENARIO_UPDATE_AVATAR],

            [['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_CHANGE_PASSWORD],

            [['name', 'surname', 'login', 'email', 'phone'], 'required', 'on' => self::SCENARIO_UPDATE_INFO],
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
            'uploadFile' => 'Аватар',
        ];
    }

    /**
     * Register new user.
     * @return bool the user is registered and logged in successfully
     */
    public function updateAvatar()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($this->upload()) {
                    $user = $this->getUser();

                    if ($user->avatar) {
                        $user->avatar->url = $this->urlFile;
                        if ($user->avatar->save()) {
                            $transaction->commit();
                            return true;
                        }
                    } else {
                        $avatar = new Avatars();
                        $avatar->url = $this->urlFile;
                        $avatar->users_id = Yii::$app->user->id;
                        if ($avatar->save()) {
                            $transaction->commit();
                            return true;
                        }
                    }
        
                    $transaction->rollBack();
                    $this->addErrors($user->errors);
                }
            } catch(\Exception $e) {
                $transaction->rollBack();
            } catch(\Throwable $e) {
                $transaction->rollBack();
            }
        }

        $this->deleteFile();
        return false;
    }

    public function deleteFile(): bool
    {
        if ($this->urlFile && file_exists($this->urlFile)) {
            return unlink($this->urlFile);
        }

        return true;
    }

    public function upload()
    {
        if (!is_dir(Yii::getAlias('@avatars'))) {
            mkdir(Yii::getAlias('@avatars'), 0755, true);
        }

        if ($this->getUser()->avatar) {
            $this->urlFile = $this->getUser()->avatar->url;
            $this->deleteFile();
        }

        $this->urlFile = Yii::getAlias('@avatars') . '/' . Yii::$app->security->generateRandomString() . '_' . time() . '.' . $this->uploadFile->extension;
        return $this->uploadFile->saveAs($this->urlFile);
    }

    /**
     * Finds user by [[login]]
     *
     * @return Users|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Users::findByLogin(Yii::$app->user->identity->login);
        }

        return $this->_user;
    }
}
