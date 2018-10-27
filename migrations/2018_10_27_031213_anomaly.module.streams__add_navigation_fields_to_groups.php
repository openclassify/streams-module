<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class AnomalyModuleStreamsAddNavigationFieldsToGroups
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AnomalyModuleStreamsAddNavigationFieldsToGroups extends Migration
{

    /**
     * Don't delete the stream
     * when rolling back.
     *
     * @var bool
     */
    protected $delete = false;

    /**
     * The field namespace.
     *
     * @var string
     */
    protected $namespace = 'streams_utilities';

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'virtualize' => 'anomaly.field_type.boolean',
        'icon'       => 'anomaly.field_type.icon',
    ];

    /**
     * The related stream.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'groups',
    ];

    /**
     * The addon assignments.
     *
     * @var array
     */
    protected $assignments = [
        'virtualize',
        'icon',
    ];

}
