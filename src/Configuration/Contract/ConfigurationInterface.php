<?php namespace Anomaly\StreamsModule\Configuration\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Interface ConfigurationInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface ConfigurationInterface extends EntryInterface
{

    /**
     * Get the related stream.
     *
     * @return StreamInterface
     */
    public function getRelated();

    /**
     * Get the index route.
     *
     * @return string
     */
    public function getIndexRoute();

    /**
     * Get the view route.
     *
     * @return string
     */
    public function getViewRoute();

}
