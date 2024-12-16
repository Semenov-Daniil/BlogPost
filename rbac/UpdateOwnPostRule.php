<?php

namespace app\rbac;

use app\models\Statuses;
use yii\rbac\Rule;

/**
 * We check the AuthorID for compliance with the user passed through the parameters
 */
class UpdateOwnPostRule extends Rule
{
    public $name = 'updateOwnPost';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['author_id'], $params['status_id']) ? ($params['author_id'] == $user && ($params['status_id'] == Statuses::getStatus('Редактирование') || $params['status_id'] == Statuses::getStatus('Одобрен'))) : false;
    }
}