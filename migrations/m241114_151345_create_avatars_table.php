<?php

use yii\db\Migration;

/**
 * Class m241114_151345_create_avatars_table
 */
class m241114_151345_create_avatars_table extends Migration
{
    const TABLE_NAME = '{{%avatars}}';
    const USERS_TABLE_NAME = '{{%users}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer()->notNull(),
            'url' => $this->string(255)->notNull(),
        ]);

        $this->createIndex('idx-avatars-users_id', self::TABLE_NAME, 'users_id');
        $this->addForeignKey('fg-avatars-users_id', self::TABLE_NAME, 'users_id', self::USERS_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fg-avatars-users_id', self::TABLE_NAME);
        $this->dropIndex('idx-avatars-users_id', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
