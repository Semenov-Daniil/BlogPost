<?php

use app\rbac\ReactionPostRule;
use yii\db\Migration;

/**
 * Class m241124_093635_create_permission_reactions_post
 */
class m241124_093635_create_permission_reactions_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $rule = new ReactionPostRule();
        $auth->add($rule);

        $reactionPost = $auth->createPermission('reactionPost');
        $reactionPost->description = 'Reaction a post';
        $reactionPost->ruleName = $rule->name;
        $auth->add($reactionPost);

        $author = $auth->getRole('author');
        $auth->addChild($author, $reactionPost);
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
