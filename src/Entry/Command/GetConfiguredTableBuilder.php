<?php namespace Anomaly\StreamsModule\Entry\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class GetConfiguredTableBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GetConfiguredTableBuilder
{

    use DispatchesJobs;

    /**
     * The stream instance.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new GetConfiguredTableBuilder instance.
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
     * @param Container $container
     * @return TableBuilder
     */
    public function handle(Container $container, Repository $config)
    {
        $stream    = $this->stream->getSlug();
        $namespace = $this->stream->getNamespace();

        if (!$parameters = $config->get("anomaly.module.streams::table.{$namespace}.{$stream}")) {
            return null;
        }

        /**
         * Try resolving the table builder.
         *
         * @var TableBuilder $builder
         */
        if ($builder = array_pull($parameters, 'builder')) {
            try {
                $builder = $container->make("anomaly.module.streams::{$namespace}.{$stream}.table");
            } catch (\Exception $e) {
                $builder = $this->dispatch(new GetDefaultTableBuilder($this->stream));
            }
        }

        return $builder;
    }
}
