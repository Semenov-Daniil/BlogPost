<?php

use app\rbac\IsAuthorRule;
use app\rbac\UpdateAuthorPostRule;
use yii\db\Migration;

/**
 * Class m241122_143631_create_permission_update_post
 */
class m241122_143631_create_permission_update_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        $admin = $auth->getRole('admin');
        $auth->addChild($admin, $updatePost);

        $rule = new IsAuthorRule();
        $auth->add($rule);

        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

        $auth->addChild($updateOwnPost, $updatePost);

        $author = $auth->getRole('author');
        $auth->addChild($author, $updateOwnPost);
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
