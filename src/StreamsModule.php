<?php namespace Anomaly\StreamsModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Class StreamsModule
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\StreamsModule
 */
class StreamsModule extends Module
{

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'streams'    => [
            'buttons' => [
                'new_stream',
                'assign_fields'    => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'enabled'     => 'admin/streams/assignments/*',
                    'href'        => 'admin/streams/assignments/{request.route.parameters.stream}/choose',
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
        'entries'    => [
            'slug'        => 'entries',
            'data-toggle' => 'modal',
            'data-target' => '#modal',
            'data-href'   => 'admin/streams/entries/{request.route.parameters.stream}',
            'href'        => 'admin/streams/entries/choose',
            'buttons'     => [
                'new_entry'        => [
                    'href' => 'admin/streams/entries/{request.route.parameters.stream}/create',
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
}
