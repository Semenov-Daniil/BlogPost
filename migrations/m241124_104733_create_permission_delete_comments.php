<?php

use yii\db\Migration;

/**
 * Class m241124_104733_create_permission_delete_comments
 */
class m241124_104733_create_permission_delete_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $deleteComment = $auth->createPermission('deleteComment');
        $deleteComment->description = 'Delete comment';
        $auth->add($deleteComment);

        $admin = $auth->getRole('admin');
        $auth->addChild($admin, $deleteComment);
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
