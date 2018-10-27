<?php namespace Anomaly\StreamsModule;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Routing\Route;

/**
 * Class StreamsModuleSections
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamsModuleSections
{

    /**
     * The default sections.
     *
     * @var array
     */
    protected $default = [
        'streams'    => [
            'buttons'  => [
                'new_stream',
                'change_namespace' => [
                    'type'        => 'info',
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'icon'        => 'fa fa-random',
                    'href'        => 'admin/streams/namespaces/change',
                ],
            ],
            'sections' => [
                'assignments' => [
                    'hidden'  => true,
                    'href'    => 'admin/streams/assignments/{request.route.parameters.stream}',
                    'buttons' => [
                        'assign_fields' => [
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'href'        => 'admin/streams/assignments/{request.route.parameters.stream}/choose',
                        ],
                    ],
                ],
            ],
        ],
        'entries'    => [
            'slug'        => 'entries',
            'data-toggle' => 'modal',
            'data-target' => '#modal',
            'data-href'   => 'admin/streams/entries/{request.route.parameters.stream}',
            'href'        => 'admin/streams/entries/choose',
            'buttons'     => [
                'new_entry' => [
                    'href' => 'admin/streams/entries/{request.route.parameters.stream}/create',
                ],
            ],
        ],
        'fields'     => [
            'buttons' => [
                'new_field'        => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'href'        => 'admin/streams/fields/choose',
                ],
                'change_namespace' => [
                    'type'        => 'info',
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'icon'        => 'fa fa-random',
                    'href'        => 'admin/streams/namespaces/change',
                ],
            ],
        ],
        'namespaces' => [
            'buttons' => [
                'new_namespace',
            ],
        ],
    ];

    /**
     * Handle the command.
     *
     * @param Route $route
     * @param Repository $config
     * @param ControlPanelBuilder $builder
     * @param GroupRepositoryInterface $groups
     */
    public function handle(
        Route $route,
        Repository $config,
        ControlPanelBuilder $builder,
        GroupRepositoryInterface $groups
    ) {

        /**
         * If we don't have a group present
         * than we don't have anything to do.
         */
        if (!$route->getAction('anomaly.module.streams::group.id')) {

            $builder->setSections($this->getDefault());

            return;
        }

        /**
         * Being that we have a group let's
         * try and build up the sections.
         *
         * @var GroupInterface $group
         */
        $group = $groups->find($route->getAction('anomaly.module.streams::group.id'));

        /**
         * If there is a CP configuration
         * for sections then use those.
         */
        if ($sections = $config->get("anomaly.module.streams::{$group->getSlug()}.cp.sections")) {

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
            if ($section = $config->get("anomaly.module.streams::{$group->getSlug()}.{$stream->getSlug()}.section")) {

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

    /**
     * Get the sections.
     *
     * @return array
     */
    public function getDefault()
    {
        return $this->default;
    }
}
