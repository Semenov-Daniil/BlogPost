<?php

use app\rbac\DeleteAuthorPostRule;
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

        $rule = new DeleteAuthorPostRule();
        $auth->add($rule);

        $deleteAuthorPost = $auth->createPermission('deleteAuthorPost');
        $deleteAuthorPost->description = 'Deleting a post by the author';
        $deleteAuthorPost->ruleName = $rule->name;
        $auth->add($deleteAuthorPost);

        $auth->addChild($deleteAuthorPost, $deletePost);

        $author = $auth->getRole('author');
        $auth->addChild($author, $deleteAuthorPost);
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
