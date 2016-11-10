<?php namespace Anomaly\StreamsModule;

use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;
use Illuminate\Session\Store;

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
     * Handle the sections.
     *
     * @param ControlPanelBuilder      $builder
     * @param GroupRepositoryInterface $groups
     * @param Store                    $session
     * @param UrlGenerator             $url
     */
    public function handle(
        ControlPanelBuilder $builder,
        GroupRepositoryInterface $groups,
        Store $session,
        UrlGenerator $url
    ) {
        $namespace = $session->get('anomaly.module.streams::namespace', 'streams');

        $button = [
            'type'     => 'info',
            'text'     => 'anomaly.module.streams::button.namespace',
            'dropdown' => [
                [
                    'text'       => 'Streams',
                    'attributes' => [
                        'class' => $namespace == 'streams' ? 'active' : null,
                    ],
                    'href'       => $url->current() . '?namespace=streams',
                ],
            ],
        ];

        /* @var GroupInterface $group */
        foreach ($groups->all() as $group) {
            $button['dropdown'][] = [
                'text'       => $group->getName(),
                'attributes' => [
                    'class' => $namespace == $group->getSlug() ? 'active' : null,
                ],
                'href'       => $url->current() . '?namespace=' . $group->getSlug(),
            ];
        }

        $builder->setSections(
            [
                'streams'    => [
                    'buttons' => [
                        'new_stream',
                        'assign_fields' => [
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'enabled'     => 'admin/streams/assignments/*',
                            'href'        => 'admin/streams/assignments/{request.route.parameters.stream}/choose',
                        ],
                        $button,
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
                        $button,
                    ],
                ],
                'fields'     => [
                    'buttons' => [
                        'new_field' => [
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'href'        => 'admin/streams/fields/choose',
                        ],
                        $button,
                    ],
                ],
                'namespaces' => [
                    'buttons' => [
                        'new_namespace',
                    ],
                ],
            ]
        );
    }
}
