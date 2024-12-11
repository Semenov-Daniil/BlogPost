<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_blocks}}`.
 */
class m241211_123045_create_users_blocks_table extends Migration
{
    const TABLE_NAME = '{{%users_blocks}}';
    const USERS_TABLE_NAME = '{{%users}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_blocks}}', [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer()->notNull(),
            'blocked_at' => $this->timestamp()->notNull(),
            'unblocked_at' => $this->timestamp()->notNull(),
            'comment' => $this->text()->notNull(),
        ]);

        $this->createIndex('idx-users_blocks-users_id', self::TABLE_NAME, 'users_id');
        $this->addForeignKey('fg-users_blocks-users_id', self::TABLE_NAME, 'users_id', self::USERS_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fg-users_blocks-users_id', self::TABLE_NAME);
        $this->dropIndex('idx-users_blocks-users_id', self::TABLE_NAME);

        $this->dropTable('{{%users_blocks}}');
    }
}
