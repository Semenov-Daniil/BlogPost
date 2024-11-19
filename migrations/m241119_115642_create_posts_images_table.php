<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts_images}}`.
 */
class m241119_115642_create_posts_images_table extends Migration
{
    const TABLE_NAME = '{{%posts_images}}';
    const POSTS_TABLE_NAME = '{{%posts}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'posts_id' => $this->integer()->notNull(),
            'path_image' => $this->string(255),
        ]);

        $this->createIndex('idx-posts_images-posts_id', self::TABLE_NAME, 'posts_id');
        $this->addForeignKey('fg-posts_images-posts_id', self::TABLE_NAME, 'posts_id', self::POSTS_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fg-posts_images-posts_id', self::TABLE_NAME);
        $this->dropIndex('idx-posts_images-posts_id', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
