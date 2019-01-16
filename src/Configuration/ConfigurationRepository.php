<?php namespace Anomaly\StreamsModule\Configuration;

use Anomaly\Streams\Platform\Entry\EntryRepository;
use Anomaly\StreamsModule\Configuration\Contract\ConfigurationInterface;
use Anomaly\StreamsModule\Configuration\Contract\ConfigurationRepositoryInterface;

/**
 * Class ConfigurationRepository
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ConfigurationRepository extends EntryRepository implements ConfigurationRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var ConfigurationModel
     */
    protected $model;

    /**
     * Create a new ConfigurationRepository instance.
     *
     * @param ConfigurationModel $model
     */
    public function __construct(ConfigurationModel $model)
    {
        $this->model = $model;
    }

    /**
     * Return only routable configuration.
     *
     * @return ConfigurationCollection
     */
    public function routable()
    {
        return $this->model
            ->whereNotNull('index_route')
            ->whereNotNull('view_route')
            ->get();
    }

    /**
     * Find a configuration by it's related ID.
     *
     * @param $id
     * @return ConfigurationInterface|null
     */
    public function findByRelatedId($id)
    {
        return $this->model->where('related_id', $id)->first();
    }

}
