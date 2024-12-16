<?php

use app\rbac\DeleteOwnPostRule;
use yii\db\Migration;

/**
 * Class m241122_143716_create_permission_delete_post
 */
class m241122_143716_create_permission_delete_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Delete post';
        $auth->add($deletePost);

        $admin = $auth->getRole('admin');
        $auth->addChild($admin, $deletePost);

        $rule = new DeleteOwnPostRule();
        $auth->add($rule);

        $deleteOwnPost = $auth->createPermission('deleteOwnPost');
        $deleteOwnPost->description = 'Delete own post';
        $deleteOwnPost->ruleName = $rule->name;
        $auth->add($deleteOwnPost);

        $auth->addChild($deleteOwnPost, $deletePost);

        $author = $auth->getRole('author');
        $auth->addChild($author, $deleteOwnPost);
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
