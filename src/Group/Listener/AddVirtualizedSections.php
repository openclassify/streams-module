<?php namespace Anomaly\StreamsModule\Group\Listener;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Event\GatherSections;
use Anomaly\StreamsModule\Group\Command\GetGroup;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;

/**
 * Class AddVirtualizedSections
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddVirtualizedSections
{

    /**
     * The groups repository.
     *
     * @var GroupRepositoryInterface
     */
    protected $groups;

    /**
     * Create a new AddVirtualizedSections instance.
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
     * @param GatherSections $event
     */
    public function handle(GatherSections $event)
    {
        $builder = $event->getBuilder();

        /**
         * Being that we have a group let's
         * try and build up the sections.
         *
         * @var GroupInterface $group
         */
        if (!$group = dispatch_now(new GetGroup(request()->route()->getAction('anomaly.module.streams::group.id')))) {
            return;
        }

        /**
         * If there is a CP configuration
         * for sections then use those.
         */
        if ($sections = config("anomaly.module.streams::{$group->getSlug()}.cp.sections")) {

            $builder->setSections($sections);

            return;
        }

        /**
         * Loop through each stream in the
         * namespace and add a section for it.
         *
         * @var StreamInterface $stream
         */
        foreach ($group->getStreams() as $k => $stream) {

            /**
             * If we have a single configuration for the
             * stream's section then use that and continue.
             */
            if ($section = config("anomaly.module.streams::{$group->getSlug()}.{$stream->getSlug()}.section")) {

                $builder->addSection($stream->getSlug(), $section);

                continue;
            }

            $href = 'admin/' . $group->getSlug() . ($k == 0 ? '' : '/' . $stream->getSlug());

            $builder->addSection(
                $stream->getSlug(),
                [
                    'href'       => $href,
                    'title'      => $stream->getName(),
                    'slug'       => $stream->getSlug(),
                    'permission' => 'anomaly.module.' . $group->getSlug() . '::' . $stream->getSlug() . '.*',
                    'buttons'    => [
                        'new_entry' => [
                            'href'       => $href . '/create',
                            'permission' => 'anomaly.module.' . $group->getSlug() . '::' . $stream->getSlug(
                                ) . '.write',
                        ],
                    ],
                ]
            );
        }
    }

}
