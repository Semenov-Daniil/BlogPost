<?php

use yii\db\Migration;

/**
 * Class m241114_135238_insert_rows_in_roles_table
 */
class m241114_135238_insert_rows_in_roles_table extends Migration
{
    const TABLE_NAME = '{{%roles}}';
    const ADMIN = 'admin';
    const AUTHOR = 'author';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(self::TABLE_NAME, ['title'], 
        [
            [
                self::ADMIN
            ],
            [
                self::AUTHOR
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE_NAME, ['title' => self::ADMIN]);
        $this->delete(self::TABLE_NAME, ['title' => self::AUTHOR]);
    }
}
