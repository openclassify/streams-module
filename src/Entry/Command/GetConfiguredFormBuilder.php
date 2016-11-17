<?php namespace Anomaly\StreamsModule\Entry\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class GetConfiguredFormBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GetConfiguredFormBuilder
{

    use DispatchesJobs;

    /**
     * The stream instance.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new GetConfiguredFormBuilder instance.
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
     * @return FormBuilder
     */
    public function handle(Container $container, Repository $config)
    {
        $stream    = $this->stream->getSlug();
        $namespace = $this->stream->getNamespace();

        if (!$parameters = $config->get("anomaly.module.streams::form.{$namespace}.{$stream}")) {
            return null;
        }

        /**
         * Try resolving the form builder.
         *
         * @var FormBuilder $builder
         */
        if ($builder = array_pull($parameters, 'builder')) {
            try {
                $builder = $container->make("anomaly.module.streams::{$namespace}.{$stream}.form");
            } catch (\Exception $e) {
                $builder = $this->dispatch(new GetDefaultFormBuilder($this->stream));
            }
        }

        return $builder;
    }
}
