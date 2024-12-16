<?php

use yii\db\Migration;

/**
 * Class m241124_104716_create_permission_create_answers_comments
 */
class m241124_104716_create_permission_create_answers_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $rule = $auth->getRule('isAuthor');

        $createAnswer = $auth->createPermission('createAnswer');
        $createAnswer->description = 'Create a answer to a comment';
        $createAnswer->ruleName = $rule->name;
        $auth->add($createAnswer);

        $author = $auth->getRole('author');
        $auth->addChild($author, $createAnswer);
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
