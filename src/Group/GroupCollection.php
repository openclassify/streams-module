<?php namespace Anomaly\StreamsModule\Group;

use Anomaly\Streams\Platform\Entry\EntryCollection;
use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;

/**
 * Class GroupCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GroupCollection extends EntryCollection
{

    /**
     * Return only accessible
     * virtualized groups.
     *
     * @return GroupCollection
     */
    public function accessible()
    {
        /* @var Authorizer $authorizer */
        $authorizer = app(Authorizer::class);

        return $this->filter(
            function ($group) use ($authorizer) {

                /* @var GroupInterface $group */
                return $authorizer->authorize('anomaly.module.' . $group->getSlug() . '::*');
            }
        );
    }
}
