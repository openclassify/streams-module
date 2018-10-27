<?php namespace Anomaly\StreamsModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Assignment\AssignmentRouter;
use Anomaly\Streams\Platform\Field\FieldRouter;
use Anomaly\Streams\Platform\Model\StreamsUtilities\StreamsUtilitiesGroupsEntryModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Event\GatherNavigation;
use Anomaly\StreamsModule\Group\Command\AddVirtualizedNavigation;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;
use Anomaly\StreamsModule\Group\GroupModel;
use Anomaly\StreamsModule\Group\GroupRepository;
use Anomaly\StreamsModule\Http\Controller\Admin\AssignmentsController;
use Anomaly\StreamsModule\Http\Controller\Admin\FieldsController;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

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
     * The addon listeners.
     *
     * @var array
     */
    protected $listeners = [
        GatherNavigation::class => [
            AddVirtualizedNavigation::class,
        ],
    ];

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
     * @param Router $router
     * @param Request $request
     * @param FieldRouter $fields
     * @param AssignmentRouter $assignments
     * @param GroupRepositoryInterface $groups
     */
    public function map(
        Router $router,
        Request $request,
        FieldRouter $fields,
        AssignmentRouter $assignments,
        GroupRepositoryInterface $groups
    ) {

        if (!$request->segment(1) == 'admin') {
            return;
        }

        $fields->route($this->addon, FieldsController::class);
        $assignments->route($this->addon, AssignmentsController::class);

        /* @var GroupInterface $group */
        foreach ($groups->virtualized() as $group) {

            $uri = 'admin/' . $group->getSlug();

            /* @var StreamInterface $stream */
            foreach ($group->getStreams() as $k => $stream) {

                $router->any(
                    $uri . ($k == 0 ? '' : '/' . $stream->getSlug()),
                    [
                        'uses'                              => 'Anomaly\StreamsModule\Http\Controller\Admin\VirtualController@index',
                        'streams::addon'                    => 'anomaly.module.streams',
                        'anomaly.module.streams::stream.id' => $stream->getId(),
                        'anomaly.module.streams::group.id'  => $group->getId(),
                    ]
                );

                $router->any(
                    $uri . ($k == 0 ? '' : '/' . $stream->getSlug()) . '/create',
                    [
                        'uses'                              => 'Anomaly\StreamsModule\Http\Controller\Admin\VirtualController@create',
                        'streams::addon'                    => 'anomaly.module.streams',
                        'anomaly.module.streams::stream.id' => $stream->getId(),
                        'anomaly.module.streams::group.id'  => $group->getId(),
                    ]
                );

                $router->any(
                    $uri . ($k == 0 ? '' : '/' . $stream->getSlug()) . '/edit/{id}',
                    [
                        'uses'                              => 'Anomaly\StreamsModule\Http\Controller\Admin\VirtualController@edit',
                        'streams::addon'                    => 'anomaly.module.streams',
                        'anomaly.module.streams::stream.id' => $stream->getId(),
                        'anomaly.module.streams::group.id'  => $group->getId(),
                    ]
                );
            }
        }
    }

    /**
     * Boot the addon.
     *
     * @param GroupRepositoryInterface $groups
     * @param Repository $config
     */
    public function boot(GroupRepositoryInterface $groups, Repository $config)
    {

        if (!$virtualized = $groups->virtualized()) {
            return;
        }

        $permissions = $config->get('anomaly.module.users::config.permissions');

        /* @var GroupInterface $group */
        foreach ($virtualized as $group) {

            $permissions['anomaly.module.' . $group->getSlug()]['title']       = $group->getName();
            $permissions['anomaly.module.' . $group->getSlug()]['description'] = $group->getDescription();

            foreach ($group->getStreams() as $stream) {

                $config->set(
                    'anomaly.module.' . $group->getSlug() . '::permissions.' . $stream->getSlug(),
                    [
                        'read',
                        'write',
                        'delete',
                    ]
                );

                $permissions['anomaly.module.' . $group->getSlug()]['permissions'][$stream->getSlug()] = [
                    'label'     => $stream->getName(),
                    'available' => [
                        'anomaly.module.' . $group->getSlug() . '::' . $stream->getSlug(
                        ) . '.read'                                                                   => 'anomaly.module.streams::permission.entries.option.read',
                        'anomaly.module.' . $group->getSlug() . '::' . $stream->getSlug(
                        ) . '.write'                                                                  => 'anomaly.module.streams::permission.entries.option.write',
                        'anomaly.module.' . $group->getSlug() . '::' . $stream->getSlug(
                        ) . '.delete'                                                                 => 'anomaly.module.streams::permission.entries.option.delete',
                    ],
                ];
            }
        }

        $config->set('anomaly.module.users::config.permissions', $permissions);
    }
}
