<?php

use app\rbac\IsAuthorRule;
use yii\db\Migration;

/**
 * Class m241124_093632_create_rule_is_author_rbac
 */
class m241124_093632_create_rule_is_author_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $rule = new IsAuthorRule();
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
