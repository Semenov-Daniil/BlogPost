<?php

use app\rbac\UserRoleRule;
use yii\db\Migration;

/**
 * Class m241114_134820_create_roles_rbac
 */
class m241114_134820_create_roles_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $rule = new UserRoleRule();
        $auth->add($rule);

        $author = $auth->createRole('author');
        $author->description = 'Автор';
        $author->ruleName = $rule->name;
        $auth->add($author);
        
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $admin->ruleName = $rule->name;
        $auth->add($admin);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
