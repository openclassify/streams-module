<?php namespace Anomaly\StreamsModule\Entry\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\StreamModel;
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
     * @param StreamInterface|StreamModel $stream
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
        $fields = $columns = array_slice($this->stream->getAssignmentFieldSlugs(), 0, 4);

        $columns = array_combine($columns, $columns);

        foreach ($columns as $field => &$column) {

//            $type = $this->stream->getFieldType($field);
//
//            if (
//                $type->hasHook('get_default_column_definition') &&
//                $default = $type->call('get_default_column_definition')
//            ) {
//                $column = $default;
//            }
        }

        $builder
            ->setOption('is_default', true)
            ->setModel($this->stream->getEntryModel())
            ->setFilters(
                [
                    'search' => [
                        'fields' => $fields,
                    ],
                ]
            )
            ->setColumns($columns);

        if ($configuration = $this->stream->call('get_configuration')) {
            $builder->addButton(
                'view',
                [
                    'target' => '_blank',
                    'href'   => '/{request.path}/view/{entry.id}',
                ]
            );
        }

        return $builder;
    }
}
