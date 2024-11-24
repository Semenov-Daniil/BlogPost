<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reactions}}`.
 */
class m241123_155403_create_reactions_table extends Migration
{
    const TABLE_NAME = '{{%reactions}}';
    const POSTS_TABLE_NAME = '{{%posts}}';
    const USERS_TABLE_NAME = '{{%users}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'reaction' => $this->tinyInteger(1)->notNull(),
            'posts_id' => $this->integer()->notNull(),
            'users_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-reactions-posts_id', self::TABLE_NAME, 'posts_id');
        $this->addForeignKey('fg-reactions-posts_id', self::TABLE_NAME, 'posts_id', self::POSTS_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
        
        $this->createIndex('idx-reactions-users_id', self::TABLE_NAME, 'users_id');
        $this->addForeignKey('fg-reactions-users_id', self::TABLE_NAME, 'users_id', self::USERS_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fg-reactions-posts_id', self::TABLE_NAME);
        $this->dropIndex('idx-reactions-posts_id', self::TABLE_NAME);

        $this->dropForeignKey('fg-reactions-users_id', self::TABLE_NAME);
        $this->dropIndex('idx-reactions-users_id', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
