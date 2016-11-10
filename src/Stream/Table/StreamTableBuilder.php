<?php namespace Anomaly\StreamsModule\Stream\Table;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Session\Store;

/**
 * Class StreamTableBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamTableBuilder extends \Anomaly\Streams\Platform\Stream\Table\StreamTableBuilder
{

    /**
     * Fired just before querying.
     *
     * @param Builder $query
     * @param Store   $session
     */
    public function onQuerying(Builder $query)
    {
        if ($this->getNamespace() == 'streams') {
            $query->whereNotIn('slug', ['groups']);
        }

        parent::onQuerying($query);
    }
}
