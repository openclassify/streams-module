<?php namespace Anomaly\StreamsModule\Configuration;

use Anomaly\Streams\Platform\Model\StreamsUtilities\StreamsUtilitiesConfigurationsEntryModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\StreamsModule\Configuration\Contract\ConfigurationInterface;

/**
 * Class ConfigurationModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ConfigurationModel extends StreamsUtilitiesConfigurationsEntryModel implements ConfigurationInterface
{

    /**
     * Eager load these relations.
     *
     * @var array
     */
    protected $with = [
        'related',
    ];

    /**
     * Get the related stream.
     *
     * @return StreamInterface
     */
    public function getRelated()
    {
        return $this->related;
    }

    /**
     * Get the index route.
     *
     * @return string
     */
    public function getIndexRoute()
    {
        return $this->index_route;
    }

    /**
     * Get the view route.
     *
     * @return string
     */
    public function getViewRoute()
    {
        return $this->view_route;
    }

}
