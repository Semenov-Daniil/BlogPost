<?php

use app\rbac\IsAuthorRule;
use app\rbac\UpdateOwnPostRule;
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

        $rule = new UpdateOwnPostRule();
        $auth->add($rule);

        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $updatePost->ruleName = $rule->name;
        $auth->add($updatePost);

        $author = $auth->getRole('author');
        $auth->addChild($author, $updatePost);
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
