<?php namespace Anomaly\StreamsModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

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
        'admin/streams'                                => 'Anomaly\StreamsModule\Http\Controller\Admin\StreamsController@index',
        'admin/streams/create'                         => 'Anomaly\StreamsModule\Http\Controller\Admin\StreamsController@create',
        'admin/streams/edit/{id}'                      => 'Anomaly\StreamsModule\Http\Controller\Admin\StreamsController@edit',
        'admin/streams/assignments/{stream}'           => 'Anomaly\StreamsModule\Http\Controller\Admin\AssignmentsController@index',
        'admin/streams/assignments/{stream}/choose'    => 'Anomaly\StreamsModule\Http\Controller\Admin\AssignmentsController@choose',
        'admin/streams/assignments/{stream}/create'    => 'Anomaly\StreamsModule\Http\Controller\Admin\AssignmentsController@create',
        'admin/streams/assignments/{stream}/edit/{id}' => 'Anomaly\StreamsModule\Http\Controller\Admin\AssignmentsController@edit',
        'admin/streams/entries/choose'                 => 'Anomaly\StreamsModule\Http\Controller\Admin\EntriesController@choose',
        'admin/streams/entries/{stream}'               => 'Anomaly\StreamsModule\Http\Controller\Admin\EntriesController@index',
        'admin/streams/entries/{stream}/create'        => 'Anomaly\StreamsModule\Http\Controller\Admin\EntriesController@create',
        'admin/streams/entries/{stream}/edit/{id}'     => 'Anomaly\StreamsModule\Http\Controller\Admin\EntriesController@edit',
        'admin/streams/fields'                         => 'Anomaly\StreamsModule\Http\Controller\Admin\FieldsController@index',
        'admin/streams/fields/choose'                  => 'Anomaly\StreamsModule\Http\Controller\Admin\FieldsController@choose',
        'admin/streams/fields/create'                  => 'Anomaly\StreamsModule\Http\Controller\Admin\FieldsController@create',
        'admin/streams/fields/edit/{id}'               => 'Anomaly\StreamsModule\Http\Controller\Admin\FieldsController@edit',
        'admin/streams/namespaces'                     => 'Anomaly\StreamsModule\Http\Controller\Admin\GroupsController@index',
        'admin/streams/namespaces/create'              => 'Anomaly\StreamsModule\Http\Controller\Admin\GroupsController@create',
        'admin/streams/namespaces/change'              => 'Anomaly\StreamsModule\Http\Controller\Admin\GroupsController@change',
        'admin/streams/namespaces/edit/{id}'           => 'Anomaly\StreamsModule\Http\Controller\Admin\GroupsController@edit',
    ];

    /**
     * The addon bindings.
     *
     * @var array
     */
    protected $bindings = [
        'Anomaly\Streams\Platform\Model\Streams\StreamsGroupsEntryModel' => 'Anomaly\StreamsModule\Group\GroupModel',
    ];

    /**
     * The addon singletons.
     *
     * @var array
     */
    protected $singletons = [
        'Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface' => 'Anomaly\StreamsModule\Group\GroupRepository',
    ];
}
