<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "bp_users".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property string $login
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $auth_key
 * @property int $roles_id
 * @property string $registered_at
 *
 * @property Avatars $avatar
 * @property Roles $role
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $uploadFile = null;
    public string $urlFile = '';

    const SCENARIO_UPDATE_INFO = 'update-info';
    const SCENARIO_CHANGE_PASSWORD = 'change-password';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['registered_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->auth_key = Yii::$app->security->generateRandomString();
            $this->roles_id = Roles::getRoles('author');
        }
        
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE_INFO] = ['name', 'surname', 'patronymic', 'email', 'login', 'phone'];
        $scenarios[self::SCENARIO_CHANGE_PASSWORD] = ['password'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'password', 'phone'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['roles_id'], 'integer'],
            [['registered_at'], 'safe'],
            [['name', 'surname', 'patronymic', 'login', 'email', 'password', 'auth_key'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^\+7\([\d]{3}\)\-[\d]{3}(\-[\d]{2}){2}$/i', 'message' => 'Только в формате +7(XXX)-XXX-XX-XX.'],
            [['login'], 'unique'],
            [['email'], 'unique'],
            [['roles_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['roles_id' => 'id']],
            [['name', 'surname', 'login', 'email', 'password', 'auth_key'], 'trim'],
            ['patronymic', 'default', 'value' => null],
            ['patronymic', 'filter', 'filter' => function($value) {
                return is_null($value) ? $value : trim($value);
            }],

            [['name', 'surname', 'login', 'email', 'phone'], 'required', 'on' => self::SCENARIO_UPDATE_INFO],
            [['password'], 'required', 'on' => self::SCENARIO_CHANGE_PASSWORD],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'login' => 'Логин',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'phone' => 'Телефон',
            'auth_key' => 'Auth Key',
            'roles_id' => 'Роль',
            'registered_at' => 'Зарегистрирован с',
            'uploadFile' => 'Аватар',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields['auth_key'], $fields['password']);

        return $fields;
    }

    /**
     * Gets query for [[Avatars]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvatar()
    {
        return $this->hasOne(Avatars::class, ['users_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['users_id' => 'id']);
    }

    /**
     * Gets query for [[Roles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::class, ['id' => 'roles_id']);
    }

    /**
     * Gets query for [[Reactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReactions()
    {
        return $this->hasMany(Reactions::class, ['users_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['users_id' => 'id']);
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    /**
     * Finds user by login
     *
     * @param string $login
     * @return static|null
     */
    public static function findByLogin(string $login): static|null
    {
        return self::findOne(['login' => $login]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * Gets whether the user is the author.
     *
     * @return bool
     */
    public function getIsAuthor(): bool
    {
        return $this->roles_id == Roles::getRoles('author');
    }

    /**
     * Gets whether the user is the admin.
     *
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return $this->roles_id == Roles::getRoles('admin');
    }
}
