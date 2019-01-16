<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class AnomalyModuleStreamsCreateConfigurationsStream
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AnomalyModuleStreamsCreateConfigurationsStream extends Migration
{

    /**
     * The field namespace.
     *
     * @var string
     */
    protected $namespace = 'streams_utilities';

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'configurations',
    ];

    /**
     * The assignment definitions.
     *
     * @var array
     */
    protected $assignments = [
        'related'         => [
            'unique'   => true,
            'required' => true,
        ],
        'index_route'    => [
            'unique' => true,
        ],
        'index_template' => [
            'required' => true,
        ],
        'view_route'     => [
            'unique' => true,
        ],
        'view_template'  => [
            'required' => true,
        ],
    ];

}
