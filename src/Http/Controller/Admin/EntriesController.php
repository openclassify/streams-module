<?php namespace Anomaly\StreamsModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\StreamsModule\Http\Middleware\SetCheckNamespace;
use Illuminate\Session\Store;

/**
 * Class EntriesController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class EntriesController extends AdminController
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

        parent::__construct();
    }

    /**
     * Return an index of existing entries.
     *
     * @param  StreamRepositoryInterface                  $streams
     * @param  TableBuilder                               $builder
     * @param                                             $stream
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(StreamRepositoryInterface $streams, TableBuilder $builder, $stream)
    {
        /* @var StreamInterface $stream */
        $stream = $streams->find($stream);

        $builder
            ->setModel($stream->getEntryModel())
            ->setColumns($stream->getConfig('table.columns'))
            ->setOptions($stream->getConfig('table.options', []))
            ->setOption('heading', 'module::admin/groups/heading')
            ->setButtons(
                $stream->getConfig(
                    'table.buttons',
                    [
                        'edit' => [
                            'href' => 'admin/streams/entries/{request.route.parameters.stream}/edit/{entry.id}',
                        ],
                    ]
                )
            )
            ->setActions(
                $stream->getConfig(
                    'table.actions',
                    [
                        'delete',
                        'edit',
                    ]
                )
            );

        return $builder->render();
    }

    /**
     * Return the modal for choosing a stream.
     *
     * @param  StreamRepositoryInterface $streams
     * @return \Illuminate\View\View
     */
    public function choose(StreamRepositoryInterface $streams)
    {
        $streams = $streams->findAllByNamespace($this->getNamespace());

        if ($this->getNamespace() == 'streams') {
            $streams = $streams->filter(
                function (StreamInterface $stream) {
                    return !in_array($stream->getSlug(), ['groups']);
                }
            );
        }

        return $this->view->make(
            'module::admin/entries/choose',
            [
                'streams' => $streams,
            ]
        );
    }

    /**
     * Create a new entry.
     *
     * @param  StreamRepositoryInterface                  $streams
     * @param  FormBuilder                                $builder
     * @param                                             $stream
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(StreamRepositoryInterface $streams, FormBuilder $builder, $stream)
    {
        /* @var StreamInterface $stream */
        $stream = $streams->find($stream);

        $builder->setOption('heading', 'module::admin/groups/heading');
        $builder->setModel($stream->getEntryModel());

        return $builder->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param  StreamRepositoryInterface                  $streams
     * @param  FormBuilder                                $builder
     * @param                                             $stream
     * @param                                             $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(StreamRepositoryInterface $streams, FormBuilder $builder, $stream, $id)
    {
        /* @var StreamInterface $stream */
        $stream = $streams->find($stream);

        $builder->setOption('heading', 'module::admin/groups/heading');
        $builder->setModel($stream->getEntryModel());

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
