<?php namespace Anomaly\StreamsModule\Entry\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class EntryTableBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EntryTableBuilder extends TableBuilder
{

    /**
     * The table buttons.
     *
     * @var array
     */
    protected $buttons = [
        'edit' => [
            'href' => '/{request.path}/edit/{entry.id}',
        ],
    ];

    /**
     * The table actions.
     *
     * @var array
     */
    protected $actions = [
        'delete',
        'edit',
    ];
}
