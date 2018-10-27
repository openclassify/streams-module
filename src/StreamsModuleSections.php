<?php namespace Anomaly\StreamsModule;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;
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
     * @param ControlPanelBuilder $builder
     * @param GroupRepositoryInterface $groups
     */
    public function handle(
        Route $route,
        ControlPanelBuilder $builder,
        GroupRepositoryInterface $groups
    ) {

        if (!$route->getAction('anomaly.module.streams::group.id')) {

            $builder->setSections($this->getDefault());

            return;
        }

        $builder->setSections([]);

        /* @var GroupInterface $group */
        $group = $groups->find($route->getAction('anomaly.module.streams::group.id'));

        $uri = 'admin/' . $group->getSlug();

        /* @var StreamInterface $stream */
        foreach ($group->getStreams() as $k => $stream) {

            $href = $uri . ($k == 0 ? '' : '/' . $stream->getSlug());

            $builder->addSection(
                $stream->getSlug(),
                [
                    'title'   => $stream->getName(),
                    'slug'    => $stream->getSlug(),
                    'href'    => $href,
                    'buttons' => [
                        'new_entry' => [
                            'href' => $href . '/create',
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
