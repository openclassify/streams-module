<?php namespace Anomaly\StreamsModule\Group\Command;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Event\GatherNavigation;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;

/**
 * Class AddVirtualizedNavigation
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddVirtualizedNavigation
{

    /**
     * The groups repository.
     *
     * @var GroupRepositoryInterface
     */
    protected $groups;

    /**
     * Create a new AddVirtualizedNavigation instance.
     *
     * @param GroupRepositoryInterface $groups
     */
    public function __construct(GroupRepositoryInterface $groups)
    {
        $this->groups = $groups;
    }

    /**
     * Handle the event.
     *
     * @param GatherNavigation $event
     */
    public function handle(GatherNavigation $event)
    {
        $builder = $event->getBuilder();

        /* @var GroupInterface $group */
        foreach ($this->groups->virtualized() as $group) {
            $builder->addNavigation(
                $group->getSlug(),
                [
                    'breadcrumb' => $group->getName(),
                    'icon'       => $group->getIcon(),
                    'title'      => $group->getName(),
                    'slug'       => $group->getSlug(),
                    'href'       => 'admin/' . $group->getSlug(),
                ]
            );
        }
    }

}
