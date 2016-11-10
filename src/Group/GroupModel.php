<?php namespace Anomaly\StreamsModule\Group;

use Anomaly\Streams\Platform\Model\Streams\StreamsGroupsEntryModel;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\UsersModule\Role\RoleCollection;

/**
 * Class GroupModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GroupModel extends StreamsGroupsEntryModel implements GroupInterface
{

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the related allowed roles.
     *
     * @return RoleCollection
     */
    public function getAllowedRoles()
    {
        return $this->allowed_roles;
    }
}
