<?php

namespace app\rbac;

use yii\rbac\Rule;

/**
 * We check the AuthorID for compliance with the user passed through the parameters
 */
class DeleteAuthorPostRule extends Rule
{
    public $name = 'deleteAuthorPost';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['post'], $params['countComments']) ? ($params['post']->users_id == $user && $params['countComments'] == 0) : false;
    }
}