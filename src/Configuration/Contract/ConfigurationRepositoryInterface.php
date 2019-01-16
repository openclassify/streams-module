<?php namespace Anomaly\StreamsModule\Configuration\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;
use Anomaly\StreamsModule\Configuration\ConfigurationCollection;

/**
 * Interface ConfigurationRepositoryInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface ConfigurationRepositoryInterface extends EntryRepositoryInterface
{

    /**
     * Return only routable configuration.
     *
     * @return ConfigurationCollection
     */
    public function routable();

    /**
     * Find a configuration by it's related ID.
     *
     * @param $id
     * @return ConfigurationInterface|null
     */
    public function findByRelatedId($id);

}
