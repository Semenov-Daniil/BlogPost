<?php

use app\rbac\IsNotAuthorRule;
use yii\db\Migration;

/**
 * Class m241124_104656_create_permission_create_comments
 */
class m241124_104656_create_permission_create_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $rule = $auth->getRule('isNotAuthor');

        $createComment = $auth->createPermission('createComment');
        $createComment->description = 'Create new comment';
        $createComment->ruleName = $rule->name;
        $auth->add($createComment);

        $author = $auth->getRole('author');
        $auth->addChild($author, $createComment);
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
