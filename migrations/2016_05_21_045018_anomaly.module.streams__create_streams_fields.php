<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class AnomalyModuleStreamsCreateStreamsFields
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AnomalyModuleStreamsCreateStreamsFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'name'          => 'anomaly.field_type.text',
        'description'   => 'anomaly.field_type.textarea',
        'slug'          => [
            'type'   => 'anomaly.field_type.slug',
            'config' => [
                'slugify' => 'name',
            ],
        ],
        'allowed_roles' => [
            'type'   => 'anomaly.field_type.multiple',
            'config' => [
                'related' => 'Anomaly\UsersModule\Role\RoleModel',
            ],
        ],
    ];
}
