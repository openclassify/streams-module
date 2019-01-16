<?php namespace Anomaly\StreamsModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Stream\Form\StreamFormBuilder;
use Anomaly\StreamsModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\StreamsModule\Configuration\Form\ConfigurationFormBuilder;
use Anomaly\StreamsModule\Http\Middleware\SetCheckNamespace;
use Anomaly\StreamsModule\Stream\Form\StreamConfigurationFormBuilder;
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
     * @param ConfigurationFormBuilder $configuration
     * @param StreamConfigurationFormBuilder $builder
     * @param StreamFormBuilder $stream
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(
        ConfigurationFormBuilder $configuration,
        StreamConfigurationFormBuilder $builder,
        StreamFormBuilder $stream
    ) {
        $builder->setOption('heading', 'module::admin/groups/heading');

        $stream->setPrefix($this->getNamespace() . '_');
        $stream->setNamespace($this->getNamespace());

        $builder->addForm('stream', $stream);
        $builder->addForm('configuration', $configuration);

        return $builder->render();
    }

    /**
     * Edit an existing stream.
     *
     * @param StreamFormBuilder $builder
     * @param                   $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(
        ConfigurationRepositoryInterface $configurations,
        ConfigurationFormBuilder $configuration,
        StreamConfigurationFormBuilder $builder,
        StreamFormBuilder $stream,
        $id)
    {
        $builder->setOption('heading', 'module::admin/groups/heading');

        $stream->setEntry($id);

        if ($entry = $configurations->findByRelatedId($id)) {
            $configuration->setEntry($entry);
        }

        $builder->addForm('stream', $stream);
        $builder->addForm('configuration', $configuration);

        return $builder->render();
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
