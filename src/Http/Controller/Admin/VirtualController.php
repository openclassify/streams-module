<?php namespace Anomaly\StreamsModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\StreamsModule\Entry\Command\GetEntryFormBuilder;
use Anomaly\StreamsModule\Entry\Command\GetEntryTableBuilder;

/**
 * Class VirtualController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class VirtualController extends AdminController
{

    /**
     * Return an index of existing entries.
     *
     * @param  StreamRepositoryInterface $streams
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(StreamRepositoryInterface $streams)
    {
        /* @var StreamInterface $stream */
        if (!$stream = $streams->find($this->route->getAction('anomaly.module.streams::stream.id'))) {
            abort(404);
        }

        $builder = $this->dispatch(new GetEntryTableBuilder($stream));

        return $builder->render();
    }

    /**
     * Create a new entry.
     *
     * @param  StreamRepositoryInterface $streams
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(StreamRepositoryInterface $streams)
    {
        /* @var StreamInterface $stream */
        if (!$stream = $streams->find($this->route->getAction('anomaly.module.streams::stream.id'))) {
            abort(404);
        }

        $builder = $this->dispatch(new GetEntryFormBuilder($stream));

        return $builder->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param  StreamRepositoryInterface $streams
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(StreamRepositoryInterface $streams)
    {
        /* @var StreamInterface $stream */
        if (!$stream = $streams->find($this->route->getAction('anomaly.module.streams::stream.id'))) {
            abort(404);
        }

        $builder = $this->dispatch(new GetEntryFormBuilder($stream));

        return $builder->render($this->route->parameter('id'));
    }

}
