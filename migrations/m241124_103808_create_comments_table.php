<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m241124_103808_create_comments_table extends Migration
{
    const TABLE_NAME = '{{%comments}}';
    const POSTS_TABLE_NAME = '{{%posts}}';
    const USERS_TABLE_NAME = '{{%users}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'posts_id' => $this->integer()->notNull(),
            'users_id' => $this->integer()->notNull(),
            'comment' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
        ]);

        $this->createIndex('idx-comments-posts_id', self::TABLE_NAME, 'posts_id');
        $this->addForeignKey('fg-comments-posts_id', self::TABLE_NAME, 'posts_id', self::POSTS_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
        
        $this->createIndex('idx-comments-users_id', self::TABLE_NAME, 'users_id');
        $this->addForeignKey('fg-comments-users_id', self::TABLE_NAME, 'users_id', self::USERS_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fg-comments-posts_id', self::TABLE_NAME);
        $this->dropIndex('idx-comments-posts_id', self::TABLE_NAME);

        $this->dropForeignKey('fg-comments-users_id', self::TABLE_NAME);
        $this->dropIndex('idx-comments-users_id', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
