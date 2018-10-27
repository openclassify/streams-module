<?php namespace Anomaly\StreamsModule\Group;

use Anomaly\Streams\Platform\Entry\EntryRepository;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;

/**
 * Class GroupRepository
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GroupRepository extends EntryRepository implements GroupRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var GroupModel
     */
    protected $model;

    /**
     * Create a new GroupRepository instance.
     *
     * @param GroupModel $model
     */
    public function __construct(GroupModel $model)
    {
        $this->model = $model;
    }

    /**
     * Find a group by it's slug.
     *
     * @param $slug
     * @return null|GroupInterface
     */
    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Return virtualized groups.
     *
     * @return GroupCollection
     */
    public function virtualized()
    {
        return $this->model->where('virtualize', true)->get();
    }

}
