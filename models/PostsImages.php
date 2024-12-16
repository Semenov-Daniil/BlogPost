<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bp_posts_images".
 *
 * @property int $id
 * @property int $posts_id
 * @property string|null $path_image
 *
 * @property Posts $post
 */
class PostsImages extends \yii\db\ActiveRecord
{
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if (file_exists($this->path_image)) {
            unlink($this->path_image);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%posts_images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['posts_id'], 'required'],
            [['posts_id'], 'integer'],
            [['path_image'], 'string', 'max' => 255],
            [['posts_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::class, 'targetAttribute' => ['posts_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'posts_id' => 'Posts ID',
            'path_image' => 'Path Image',
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::class, ['id' => 'posts_id']);
    }

    public static function getIdByPathImage(string $pathImage): int|null
    {
        return self::findOne(['path_image' => $pathImage])?->id;
    }

    public static function findImageByPost(int $postId): static|null
    {
        return self::findOne(['posts_id' => $postId]);
    }
}
