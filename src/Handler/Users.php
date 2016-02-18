<?php namespace Anomaly\RelationshipFieldType\Handler;

use Anomaly\RelationshipFieldType\RelationshipFieldType;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;

/**
 * Class Users
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\RelationshipFieldType
 */
class Users
{

    /**
     * Handle the options.
     *
     * @param RelationshipFieldType $fieldType
     * @return array
     */
    public function handle(RelationshipFieldType $fieldType, UserRepositoryInterface $users)
    {
        $users = $users->all();

        $fieldType->setOptions(
            $users->lists(
                'email',
                'id'
            )->all()
        );
    }
}
