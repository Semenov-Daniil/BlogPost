<?php

use yii\db\Migration;

/**
 * Class m241202_074902_insert_rows_in_statuses_table
 */
class m241202_074902_insert_rows_in_statuses_table extends Migration
{
    const TABLE_NAME = '{{%statuses}}';
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
                'Редактирование'
            ],
            [
                'Одобрен'
            ],
            [
                'Запрещен'
            ],
            [
                'На модерации'
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE_NAME, ['title' => 'Редактирование']);
        $this->delete(self::TABLE_NAME, ['title' => 'Одобрен']);
        $this->delete(self::TABLE_NAME, ['title' => 'Запрещен']);
        $this->delete(self::TABLE_NAME, ['title' => 'На модерации']);
    }
}
