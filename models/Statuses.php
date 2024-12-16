<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bp_statuses".
 *
 * @property int $id
 * @property string $title
 *
 * @property Posts[] $posts
 */
class Statuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%statuses}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['statuses_id' => 'id']);
    }

    /**
     * Finds id status by title.
     *
     * @param string $title
     * @return int|null
     */
    public static function getIdByTitle(string $title): int|null
    {
        return self::findOne(['title' => $title])?->id;
    }

    /**
     * Gets styles statuses.
     *
     * @return array
     */
    public static function getStylesStatus(): array
    {
        return [
            'Редактирование' => 'text-bg-warning',
            'Одобрен' => 'text-bg-success',
            'Запрещен' => 'text-bg-danger',
            'На модерации' => 'text-bg-info',
        ];
    } 

    public static function getStatuses()
    {
        return self::find()
            ->select('title')
            ->indexBy('id')
            ->column()
        ;
    }
}
