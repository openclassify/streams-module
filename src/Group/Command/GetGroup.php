<?php namespace Anomaly\StreamsModule\Group\Command;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;

/**
 * Class GetGroup
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GetGroup
{

    /**
     * The group identifier.
     *
     * @var mixed
     */
    protected $identifier;

    /**
     * Create a new GetRole instance.
     *
     * @param $identifier
     */
    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Handle the command.
     *
     * @param  GroupRepositoryInterface $groups $roles
     * @return GroupInterface|EloquentModel|null
     */
    public function handle(GroupRepositoryInterface $groups)
    {
        if (is_numeric($this->identifier)) {
            return $groups->find($this->identifier);
        }

        if (!is_numeric($this->identifier)) {
            return $groups->findBySlug($this->identifier);
        }

        return null;
    }
}
