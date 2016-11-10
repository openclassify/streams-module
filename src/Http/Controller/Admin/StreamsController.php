<?php namespace Anomaly\StreamsModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Stream\Form\StreamFormBuilder;
use Anomaly\StreamsModule\Http\Middleware\AuthorizeNamespace;
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
        $this->namespace = $session->get('anomaly.module.streams::namespace', 'streams');

        $this->middleware(SetCheckNamespace::class);
        $this->middleware(AuthorizeNamespace::class);

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
            ->setNamespace($this->getNamespace())
            ->setOption('heading', 'module::admin/groups/heading')
            ->setOption('heading', 'module::admin/groups/heading')
            ->setButtons(['entries', 'edit', 'assignments']);

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
        $builder->setNamespace($this->getNamespace());
        $builder->setPrefix('streams_');

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
        $builder->setPrefix('streams_');

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
