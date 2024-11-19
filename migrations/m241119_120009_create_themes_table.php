<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%themes}}`.
 */
class m241119_120009_create_themes_table extends Migration
{
    const TABLE_NAME = '{{%themes}}';

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
