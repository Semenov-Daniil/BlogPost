<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answers_comments}}`.
 */
class m241124_104127_create_answers_comments_table extends Migration
{
    const TABLE_NAME = '{{%answers_comments}}';
    const COMMENTS_TABLE_NAME = '{{%comments}}';
    const USERS_TABLE_NAME = '{{%users}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer()->notNull(),
            'comments_id' => $this->integer()->notNull(),
            'answer' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
        ]);

        $this->createIndex('idx-answers_comments-users_id', self::TABLE_NAME, 'users_id');
        $this->addForeignKey('fg-answers_comments-users_id', self::TABLE_NAME, 'users_id', self::USERS_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('idx-answers_comments-comments_id', self::TABLE_NAME, 'comments_id');
        $this->addForeignKey('fg-answers_comments-comments_id', self::TABLE_NAME, 'comments_id', self::COMMENTS_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fg-answers_comments-users_id', self::TABLE_NAME);
        $this->dropIndex('idx-answers_comments-users_id', self::TABLE_NAME);

        $this->dropForeignKey('fg-answers_comments-comments_id', self::TABLE_NAME);
        $this->dropIndex('idx-answers_comments-comments_id', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
