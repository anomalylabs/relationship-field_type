<?php namespace Anomaly\RelationshipFieldType\Handler;

use Anomaly\RelationshipFieldType\RelationshipFieldType;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;

/**
 * Class Users
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
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
