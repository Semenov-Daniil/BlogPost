<?php

namespace app\rbac;

use app\models\Roles;
use Yii;
use yii\rbac\Rule;

/**
 * Checks if user role matches
 */
class UserRoleRule extends Rule
{
    public $name = 'userRole';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->roles_id;
            return $role == Roles::getRoles($item->name);
        }
        return false;
    }
}