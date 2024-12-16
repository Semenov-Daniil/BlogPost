<?php

use app\rbac\IsNotAuthorRule;
use yii\db\Migration;

/**
 * Class m241124_093630_create_rule_is_not_author_rbac
 */
class m241124_093630_create_rule_is_not_author_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $rule = new IsNotAuthorRule();
        $auth->add($rule);
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
