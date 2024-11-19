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
 * @property Posts $posts
 */
class PostsImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bp_posts_images';
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
    public function getPosts()
    {
        return $this->hasOne(Posts::class, ['id' => 'posts_id']);
    }
}
