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
        'streams' => [
            'buttons' => [
                'new_stream',
                'assign_fields' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'enabled'     => 'admin/streams/assignments/*',
                    'href'        => 'admin/streams/assignments/{request.route.parameters.stream}/choose'
                ]
            ]
        ],
        'entries' => [
            'buttons' => [
                'new_entries'
            ]
        ],
        'fields'  => [
            'buttons' => [
                'new_field' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'href'        => 'admin/streams/fields/choose'
                ]
            ]
        ]
    ];

}
