<?php

namespace app\models;

use Exception;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "bp_posts".
 *
 * @property int $id
 * @property string $title
 * @property string $preview
 * @property string $text
 * @property int $users_id
 * @property int $themes_id
 * @property int $statuses_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PostsImages $postImage
 * @property Statuses $statuses
 * @property Themes $themes
 * @property Users $users
 * @property Reactions $reactions
 */
class Posts extends \yii\db\ActiveRecord
{
    public $uploadFile;
    public string|null $pathFile = null;
    public string $other_theme = '';
    public bool $check = false;
    public string $theme = '';
    public string $status = '';
    public string $author = '';
    public int $count_comments = 0;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
            $this->users_id = Yii::$app->user->identity->id;
        }
        
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'preview', 'text'], 'required'],
            [['users_id', 'themes_id', 'statuses_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'preview', 'theme'], 'string', 'max' => 255],
            [['text'], 'string'],
            [['check'], 'boolean'],
            [['uploadFile'], 'image'],
            [['statuses_id'], 'exist', 'skipOnError' => true, 'targetClass' => Statuses::class, 'targetAttribute' => ['statuses_id' => 'id']],
            [['themes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Themes::class, 'targetAttribute' => ['themes_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['users_id' => 'id']],
            ['themes_id', 'required', 'when' => function($model) {
                return !$model->check;
            }, 'whenClient' => "function (attribute, value) {
                return !$('#posts-check').prop('checked');
            }"],
            ['other_theme', 'required', 'when' => function($model) {
                return $model->check;
            }, 'whenClient' => "function (attribute, value) {
                return $('#posts-check').prop('checked');
            }"],
            ['other_theme', 'filter', 'filter' => [$this, 'normalizeTheme']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'preview' => 'Превью',
            'text' => 'Текст',
            'users_id' => 'Автор',
            'themes_id' => 'Тема',
            'theme' => 'Тема',
            'statuses_id' => 'Статус ID',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'uploadFile' => 'Изображение',
            'other_theme' => 'Своя тема',
            'check' => 'Другая тема',
        ];
    }

    public function normalizeTheme($value) {
        $converter = [
            'A' => 'А',
            'B' => 'В',
            'C' => 'С',
            'E' => 'Е',
            'H' => 'Н',
            'K' => 'К',
            'M' => 'М',
            'O' => 'О',
            'P' => 'Р',
            'T' => 'Т',
            'X' => 'Х',
            'Y' => 'У',
            'a' => 'а',
            'c' => 'с',
            'e' => 'е',
            'k' => 'к',
            'o' => 'о',
            'p' => 'р',
            'x' => 'х',
            'y' => 'у',
        ];

        $convertedString = strtr($value, $converter);
        return $convertedString;
    }

    /**
     * Gets query for [[PostsImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(PostsImages::class, ['posts_id' => 'id']);
    }

    /**
     * Gets query for [[Statuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Statuses::class, ['id' => 'statuses_id']);
    }

    /**
     * Gets query for [[Themes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Themes::class, ['id' => 'themes_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['posts_id' => 'id']);
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

    /**
     * Gets query for [[Reactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReactions()
    {
        return $this->hasMany(Reactions::class, ['posts_id' => 'id']);
    }

    public function getCountLikes()
    {
        return Reactions::find()
            ->where(['posts_id' => $this->id, 'reaction' => 1])
            ->count();
    }

    public function getCountDislikes()
    {
        return Reactions::find()
            ->where(['posts_id' => $this->id, 'reaction' => 0])
            ->count();
    }

    public function addTheme(): bool
    {
        if ($this->check) { 
            $theme = Themes::getIdByTitle($this->other_theme);

            if (is_null($theme)) {
                $theme = new Themes();
                $theme->title = $this->other_theme;
                if (!$theme->save()) {
                    $this->addErrors($theme->errors);
                    throw new Exception("Couldn't save a new theme");
                    return false;
                }
                $this->themes_id = $theme->id;
            } else {
                $this->themes_id = $theme;
                $this->other_theme = '';
                $this->check = false;
            }
        }

        return true;
    }

    public function addImage(): bool
    {
        $image = new PostsImages();
        $image->path_image = $this->pathFile;
        $image->posts_id = $this->id;
        if (!$image->save()) {
            $this->addErrors($image->errors);
            throw new Exception("Couldn't save a new image.");
            return false;
        }
        
        return true;
    }

    public function updateImage(): bool
    {
        $image = PostsImages::findImageByPost($this->id);

        if ($image) {
            $this->deleteFile($image->path_image);
            $image->path_image = $this->pathFile;
            return $image->save();
        } else {
            return $this->addImage();
        }
    }

    /**
     * Create new post
     * 
     * @return bool 
     */
    public function create(): bool
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $this->statuses_id = Statuses::getIdByTitle('Редактирование');

                if ($this->addTheme()) {
                    $this->save(false);

                    if (is_null($this->uploadFile) || ($this->uploadImage() && $this->addImage())) {
                        $transaction->commit();
                        return true;
                    }
                }

                $transaction->rollBack();
            } catch(\Exception $e) {
                $transaction->rollBack();
            } catch(\Throwable $e) {
                $transaction->rollBack();
            }
        }

        $this->deleteFile($this->pathFile);
        return false;
    }

    /**
     * Update post
     * 
     * @return bool 
     */
    public function updatePost(): bool
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $this->statuses_id = Statuses::getIdByTitle('Редактирование');

                if ($this->addTheme()) {
                    $this->save(false);

                    if (is_null($this->uploadFile) || ($this->uploadImage() && $this->updateImage())) {
                        $transaction->commit();
                        return true;
                    }
                }

                $transaction->rollBack();
            } catch(\Exception $e) {
                $transaction->rollBack();
            } catch(\Throwable $e) {
                $transaction->rollBack();
            }
        }

        $this->deleteFile($this->pathFile);
        return false;
    }

    public function uploadImage()
    {
        if (!is_dir(Yii::getAlias('@posts'))) {
            mkdir(Yii::getAlias('@posts'), 0755, true);
        }

        $this->pathFile = Yii::getAlias('@posts') . '/' . Yii::$app->security->generateRandomString() . '_' . time() . '.' . $this->uploadFile->extension;
        return $this->uploadFile->saveAs($this->pathFile);
    }

    public function deleteFile($path): bool
    {
        if ($path && file_exists($path)) {
            return unlink($path);
        }

        return true;
    }

    public static function getLastPosts($limit)
    {
        $query = self::find()
            ->select([
                self::tableName() . '.id', 
                self::tableName() . '.title', 
                'preview', 
                'text', 
                Themes::tableName() . '.title as theme',
                'users_id',
                'login as author', 
                'statuses_id',
                'created_at',
                'updated_at',
                'path_image as pathFile',
            ])
            ->joinWith('user', false)
            ->joinWith('theme', false)
            ->joinWith('image', false)
            ->where(['statuses_id' => Statuses::getIdByTitle('Одобрен')])
            ->orderBy([
                'created_at' => SORT_DESC,
            ])
            ->limit($limit)
            ;

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);
    }

    public static function getPost($id)
    {
        $subQuery = Comments::find()
            ->select('COUNT(*)')
            ->where('posts_id=:id', [':id' => $id])
        ;

        return self::find()
            ->select([
                self::tableName() . '.id', 
                self::tableName() . '.title', 
                'preview', 
                'text', 
                Themes::tableName() . '.title as theme',
                self::tableName() . '.users_id',
                'login as author', 
                'themes_id',
                'statuses_id',
                'created_at',
                'updated_at',
                'path_image as pathFile',
                'count_comments' => $subQuery
            ])
            ->joinWith('user', false)
            ->joinWith('theme', false)
            ->joinWith('image', false)
            ->where(Posts::tableName() . '.id=:id', [':id' => $id])
            ->one()
        ;
    }

    public function deletePost()
    {
        if ($this->image) {
            $this->image->delete();
        }

        $this->delete();
    }
}
