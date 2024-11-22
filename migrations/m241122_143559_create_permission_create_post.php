<?php

use yii\db\Migration;

/**
 * Class m241122_143559_create_permission_create_post
 */
class m241122_143559_create_permission_create_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        $author = $auth->getRole('author');
        $auth->addChild($author, $createPost);
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
