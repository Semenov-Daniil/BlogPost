<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bp_roles".
 *
 * @property int $id
 * @property string $title
 *
 * @property Users[] $users
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%roles}}';
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
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['roles_id' => 'id']);
    }

    /**
     * Finds id role by title.
     *
     * @param string $title
     * @return int|null
     */
    public static function getRoles(string $title): int|null
    {
        return self::findOne(['title' => $title])?->id;
    } 
}
