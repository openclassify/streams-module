<?php namespace Anomaly\StreamsModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Assignment\AssignmentRouter;
use Anomaly\Streams\Platform\Field\FieldRouter;
use Anomaly\Streams\Platform\Model\StreamsUtilities\StreamsUtilitiesGroupsEntryModel;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;
use Anomaly\StreamsModule\Group\GroupModel;
use Anomaly\StreamsModule\Group\GroupRepository;
use Anomaly\StreamsModule\Http\Controller\Admin\AssignmentsController;
use Anomaly\StreamsModule\Http\Controller\Admin\FieldsController;

/**
 * Class StreamsModuleServiceProvider
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\StreamsModule
 */
class StreamsModuleServiceProvider extends AddonServiceProvider
{

    /**
     * The addon routes.
     *
     * @var array
     */
    protected $routes = [
        'admin/streams'                            => 'Anomaly\StreamsModule\Http\Controller\Admin\StreamsController@index',
        'admin/streams/create'                     => 'Anomaly\StreamsModule\Http\Controller\Admin\StreamsController@create',
        'admin/streams/edit/{id}'                  => 'Anomaly\StreamsModule\Http\Controller\Admin\StreamsController@edit',
        'admin/streams/entries/choose'             => 'Anomaly\StreamsModule\Http\Controller\Admin\EntriesController@choose',
        'admin/streams/entries/{stream}'           => 'Anomaly\StreamsModule\Http\Controller\Admin\EntriesController@index',
        'admin/streams/entries/{stream}/create'    => 'Anomaly\StreamsModule\Http\Controller\Admin\EntriesController@create',
        'admin/streams/entries/{stream}/edit/{id}' => 'Anomaly\StreamsModule\Http\Controller\Admin\EntriesController@edit',
        'admin/streams/namespaces'                 => 'Anomaly\StreamsModule\Http\Controller\Admin\GroupsController@index',
        'admin/streams/namespaces/create'          => 'Anomaly\StreamsModule\Http\Controller\Admin\GroupsController@create',
        'admin/streams/namespaces/change'          => 'Anomaly\StreamsModule\Http\Controller\Admin\GroupsController@change',
        'admin/streams/namespaces/edit/{id}'       => 'Anomaly\StreamsModule\Http\Controller\Admin\GroupsController@edit',
    ];

    /**
     * The addon bindings.
     *
     * @var array
     */
    protected $bindings = [
        StreamsUtilitiesGroupsEntryModel::class => GroupModel::class,
    ];

    /**
     * The addon singletons.
     *
     * @var array
     */
    protected $singletons = [
        GroupRepositoryInterface::class => GroupRepository::class,
    ];

    /**
     * Map the addon.
     *
     * @param FieldRouter      $fields
     * @param AssignmentRouter $assignments
     */
    public function map(FieldRouter $fields, AssignmentRouter $assignments)
    {
        $fields->route($this->addon, FieldsController::class);
        $assignments->route($this->addon, AssignmentsController::class);
    }
}
