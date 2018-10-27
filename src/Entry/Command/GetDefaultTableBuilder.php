<?php namespace Anomaly\StreamsModule\Entry\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\StreamsModule\Entry\Table\EntryTableBuilder;

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
     * @param EntryTableBuilder $builder
     * @return EntryTableBuilder
     */
    public function handle(EntryTableBuilder $builder)
    {
        return $builder
            ->setOption('is_default', true)
            ->setModel($this->stream->getEntryModel())
            ->setFilters(
                [
                    'search' => [
                        'fields' => array_slice($this->stream->getAssignmentFieldSlugs(), 0, 4),
                    ],
                ]
            )
            ->setColumns(array_slice($this->stream->getAssignmentFieldSlugs(), 0, 4));
    }
}
