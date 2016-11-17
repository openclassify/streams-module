<?php namespace Anomaly\StreamsModule\Group\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\UsersModule\Role\RoleCollection;

/**
 * Interface GroupInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface GroupInterface extends EntryInterface
{

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Get the related allowed roles.
     *
     * @return RoleCollection
     */
    public function getAllowedRoles();
}
