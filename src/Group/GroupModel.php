<?php namespace Anomaly\StreamsModule\Group;

use Anomaly\Streams\Platform\Model\StreamsUtilities\StreamsUtilitiesGroupsEntryModel;
use Anomaly\Streams\Platform\Stream\StreamCollection;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\UsersModule\Role\RoleCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class GroupModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GroupModel extends StreamsUtilitiesGroupsEntryModel implements GroupInterface
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
     * Get the icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Get the virtualized flag.
     *
     * @return bool
     */
    public function isVirtualized()
    {
        return $this->virtualize;
    }

    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the related streams.
     *
     * @return StreamCollection
     */
    public function getStreams()
    {
        return $this->streams;
    }

    /**
     * Return the streams relation.
     *
     * @return HasMany
     */
    public function streams()
    {
        return $this->hasMany(StreamModel::class, 'namespace', 'slug');
    }
}
