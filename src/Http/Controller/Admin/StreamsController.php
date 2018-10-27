<?php namespace Anomaly\StreamsModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Stream\Form\StreamFormBuilder;
use Anomaly\StreamsModule\Http\Middleware\SetCheckNamespace;
use Anomaly\StreamsModule\Stream\Table\StreamTableBuilder;
use Illuminate\Session\Store;

/**
 * Class StreamsController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\StreamsModule\Http\Controller\Admin
 */
class StreamsController extends AdminController
{

    /**
     * The working namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * Create a new StreamsController instance.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->middleware(SetCheckNamespace::class);

        $this->namespace = $session->get('anomaly.module.streams::namespace');

        parent::__construct();
    }

    /**
     * Return an index of existing streams.
     *
     * @param StreamTableBuilder $builder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(StreamTableBuilder $builder)
    {
        $builder
            ->setActions(['prompt'])
            ->setOption('sortable', true)
            ->setNamespace($this->getNamespace())
            ->setOption('heading', 'module::admin/groups/heading')
            ->setButtons(
                [
                    'entries',
                    'edit',
                    'assignments',
                ]
            );

        return $builder->render();
    }

    /**
     * Create a new stream.
     *
     * @param StreamFormBuilder $builder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(StreamFormBuilder $builder)
    {
        $builder->setOption('heading', 'module::admin/groups/heading');
        $builder->setPrefix($this->getNamespace() . '_');
        $builder->setNamespace($this->getNamespace());

        return $builder->render();
    }

    /**
     * Edit an existing stream.
     *
     * @param StreamFormBuilder $builder
     * @param                   $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(StreamFormBuilder $builder, $id)
    {
        $builder->setOption('heading', 'module::admin/groups/heading');
        
        return $builder->render($id);
    }

    /**
     * Get the namespace.
     *
     * @return string
     */
    protected function getNamespace()
    {
        return $this->namespace;
    }
}
