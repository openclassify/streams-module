<?php namespace Anomaly\StreamsModule\Entry\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class GetDefaultTableBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GetDefaultTableBuilder
{

    /**
     * The stream instance.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new GetDefaultTableBuilder instance.
     *
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Handle the command.
     *
     * @param TableBuilder $builder
     * @return TableBuilder
     */
    public function handle(TableBuilder $builder)
    {
        return $builder
            ->setModel($this->stream->getEntryModel())
            ->setFilters(
                [
                    'search' => [
                        'fields' => array_slice($this->stream->getAssignmentFieldSlugs(), 0, 4),
                    ],
                ]
            )
            ->setColumns(array_slice($this->stream->getAssignmentFieldSlugs(), 0, 4))
            ->setButtons(
                [
                    'edit' => [
                        'href' => 'admin/streams/entries/{request.route.parameters.stream}/edit/{entry.id}',
                    ],
                ]
            )
            ->setActions(
                [
                    'delete',
                    'edit',
                ]
            );
    }
}
