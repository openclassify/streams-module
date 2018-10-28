<?php namespace Anomaly\StreamsModule\Group\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\StreamCollection;
use Anomaly\UsersModule\Role\RoleCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Get the icon.
     *
     * @return string
     */
    public function getIcon();

    /**
     * Get the virtualized flag.
     *
     * @return bool
     */
    public function isVirtualized();

    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the related streams.
     *
     * @return StreamCollection
     */
    public function getStreams();

    /**
     * Return the streams relation.
     *
     * @return HasMany
     */
    public function streams();
}
