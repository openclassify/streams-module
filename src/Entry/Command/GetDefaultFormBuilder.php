<?php namespace Anomaly\StreamsModule\Entry\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class GetDefaultFormBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GetDefaultFormBuilder
{

    /**
     * The stream instance.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new GetDefaultFormBuilder instance.
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
     * @param FormBuilder $builder
     * @return FormBuilder
     */
    public function handle(FormBuilder $builder)
    {
        return $builder
            ->setOption('is_default', true)
            ->setModel($this->stream->getEntryModel());
    }
}
