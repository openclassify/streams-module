<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class AnomalyModuleStreamsCreateGroupsStream
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AnomalyModuleStreamsCreateGroupsStream extends Migration
{

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'         => 'groups',
        'sortable'     => true,
        'translatable' => true,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'name'        => [
            'required'     => true,
            'translatable' => true,
        ],
        'slug'        => [
            'unique'   => true,
            'required' => true,
        ],
        'description' => [
            'translatable' => true,
        ],
        'allowed_roles',
    ];

}
