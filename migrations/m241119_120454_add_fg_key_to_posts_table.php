<?php

use yii\db\Migration;

/**
 * Class m241119_120454_add_fg_key_to_posts_table
 */
class m241119_120454_add_fg_key_to_posts_table extends Migration
{
    const TABLE_NAME = '{{%posts}}';
    const THEMES_TABLE_NAME = '{{%themes}}';
    const STATUSES_TABLE_NAME = '{{%statuses}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx-posts-themes_id', self::TABLE_NAME, 'themes_id');
        $this->addForeignKey('fg-posts-themes_id', self::TABLE_NAME, 'themes_id', self::THEMES_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
        
        $this->createIndex('idx-posts-statuses_id', self::TABLE_NAME, 'statuses_id');
        $this->addForeignKey('fg-posts-statuses_id', self::TABLE_NAME, 'statuses_id', self::STATUSES_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fg-posts-themes_id', self::TABLE_NAME);
        $this->dropIndex('idx-posts-themes_id', self::TABLE_NAME);

        $this->dropForeignKey('fg-posts-statuses_id', self::TABLE_NAME);
        $this->dropIndex('idx-posts-statuses_id', self::TABLE_NAME);
    }
}
