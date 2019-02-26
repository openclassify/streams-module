<?php namespace Anomaly\StreamsModule\Group\Listener;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;

/**
 * Class LocateVirtualizedModels
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LocateVirtualizedModels
{

    /**
     * The groups repository.
     *
     * @var GroupRepositoryInterface
     */
    protected $groups;

    /**
     * Create a new LocateVirtualizedModels instance.
     *
     * @param GroupRepositoryInterface $groups
     */
    public function __construct(GroupRepositoryInterface $groups)
    {
        $this->groups = $groups;
    }

    /**
     * Handle the event.
     */
    public function handle()
    {
        /* @var GroupInterface $group */
        foreach ($this->groups->virtualized() as $group) {

            /* @var StreamInterface $stream */
            foreach ($group->getStreams() as $stream) {
                $stream
                    ->getEntryModel()
                    ->bind(
                        '__locate',
                        function () use ($group) {
                            return 'anomaly.module.' . $group->getSlug();
                        }
                    );
            }
        }
    }

}
