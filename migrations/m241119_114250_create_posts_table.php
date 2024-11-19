<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 */
class m241119_114250_create_posts_table extends Migration
{
    const TABLE_NAME = '{{%posts}}';
    const USERS_TABLE_NAME = '{{%users}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'preview' => $this->string(255)->notNull(),
            'text' => $this->string()->notNull(),
            'users_id' => $this->integer()->notNull(),
            'themes_id' => $this->integer()->notNull(),
            'statuses_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);

        $this->createIndex('idx-posts-users_id', self::TABLE_NAME, 'users_id');
        $this->addForeignKey('fg-posts-users_id', self::TABLE_NAME, 'users_id', self::USERS_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fg-posts-users_id', self::TABLE_NAME);
        $this->dropIndex('idx-posts-users_id', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
