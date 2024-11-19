<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%statuses}}`.
 */
class m241119_120114_create_statuses_table extends Migration
{
    const TABLE_NAME = '{{%statuses}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
