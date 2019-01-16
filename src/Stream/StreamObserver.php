<?php namespace Anomaly\StreamsModule\Stream;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Support\Observer;
use Anomaly\StreamsModule\Configuration\ConfigurationModel;

/**
 * Class StreamObserver
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamObserver extends Observer
{

    public function deleted(StreamInterface $model)
    {
        if ($configuration = ConfigurationModel::where('related_id', $model->getId())->first()) {
            $configuration->delete();
        }
    }

}
