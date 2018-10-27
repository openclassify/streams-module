<?php namespace Anomaly\StreamsModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;
use Anomaly\StreamsModule\Group\Form\GroupFormBuilder;
use Anomaly\StreamsModule\Group\Table\GroupTableBuilder;
use Anomaly\StreamsModule\Http\Middleware\SetCheckNamespace;

/**
 * Class GroupsController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GroupsController extends AdminController
{

    /**
     * Create a new StreamsController instance.
     */
    public function __construct()
    {
        $this->middleware(SetCheckNamespace::class);

        parent::__construct();
    }

    /**
     * Display an index of existing entries.
     *
     * @param GroupTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(GroupTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Return the modal to change the namespace.
     *
     * @param GroupRepositoryInterface $groups
     * @return \Illuminate\Contracts\View\View|mixed
     */
    public function change(GroupRepositoryInterface $groups)
    {
        return $this->view->make(
            'anomaly.module.streams::admin/groups/change',
            [
                'groups' => $groups->all(),
            ]
        );
    }

    /**
     * Create a new entry.
     *
     * @param GroupFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(GroupFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param GroupFormBuilder $form
     * @param                  $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(GroupFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
