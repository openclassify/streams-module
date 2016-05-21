<?php namespace Anomaly\StreamsModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class EntriesController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\StreamsModule\Http\Controller\Admin
 */
class EntriesController extends AdminController
{

    /**
     * Return an index of existing entries.
     *
     * @param StreamRepositoryInterface $streams
     * @param TableBuilder              $builder
     * @param                           $stream
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(StreamRepositoryInterface $streams, TableBuilder $builder, $stream)
    {
        /* @var StreamInterface $stream */
        $stream = $streams->find($stream);

        $builder
            ->setModel($stream->getEntryModel())
            ->setOption('sortable', $stream->isSortable())
            ->setOption('limit', $stream->isSortable() ? 9999 : null)
            ->setButtons(
                [
                    'edit' => [
                        'href' => 'admin/streams/entries/{request.route.parameters.stream}/edit/{entry.id}'
                    ]
                ]
            )
            ->setColumns(
                [
                    'entry.cover.preview',
                    'entry.images.count'
                ]
            )
            ->setActions(
                [
                    'delete',
                    'edit'
                ]
            );

        return $builder->render();
    }

    /**
     * Return the modal for choosing a stream.
     *
     * @param StreamRepositoryInterface $streams
     * @return \Illuminate\View\View
     */
    public function choose(StreamRepositoryInterface $streams)
    {
        return view(
            'module::ajax/choose_stream',
            [
                'streams' => $streams->findAllByNamespace('streams')
            ]
        );
    }

    /**
     * Create a new entry.
     *
     * @param StreamRepositoryInterface $streams
     * @param FormBuilder               $builder
     * @param                           $stream
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(StreamRepositoryInterface $streams, FormBuilder $builder, $stream)
    {
        /* @var StreamInterface $stream */
        $stream = $streams->find($stream);

        $builder->setModel($stream->getEntryModel());

        return $builder->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param StreamRepositoryInterface $streams
     * @param FormBuilder               $builder
     * @param                           $stream
     * @param                           $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(StreamRepositoryInterface $streams, FormBuilder $builder, $stream, $id)
    {
        /* @var StreamInterface $stream */
        $stream = $streams->find($stream);

        $builder->setModel($stream->getEntryModel());

        return $builder->render($id);
    }
}
