<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m241114_135918_create_users_table extends Migration
{
    const TABLE_NAME = '{{%users}}';
    const ROLES_TABLE_NAME = '{{%roles}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'surname' => $this->string(255)->notNull(),
            'patronymic' => $this->string(255)->defaultValue(null),
            'login' => $this->string(255)->notNull()->unique(),
            'email' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'phone' => $this->string(20)->notNull(),
            'auth_key' => $this->string(255)->notNull(),
            'roles_id' => $this->integer()->notNull(),
            'registered_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-users-roles_id', self::TABLE_NAME, 'roles_id');
        $this->addForeignKey('fg-users-roles_id', self::TABLE_NAME, 'roles_id', self::ROLES_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fg-users-roles_id', self::TABLE_NAME);
        $this->dropIndex('idx-users-roles_id', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
