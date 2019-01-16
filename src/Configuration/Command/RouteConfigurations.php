<?php namespace Anomaly\Streams\Platform\Model\Configuration\Command;

use Anomaly\StreamsModule\Configuration\Contract\ConfigurationInterface;
use Anomaly\StreamsModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Illuminate\Routing\Router;

/**
 * Class RouteConfigurations
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RouteConfigurations
{

    /**
     * Handle the command.
     *
     * @param ConfigurationRepositoryInterface $configurations
     * @param Router $router
     */
    public function handle(ConfigurationRepositoryInterface $configurations, Router $router)
    {

        /* @var ConfigurationInterface $configuration */
        foreach ($configurations->routable() as $configuration) {

            $stream = $configuration->getRelated();

            $prefix = 'anomaly.module.' . $stream->getNamespace() . '::' . $stream->getSlug() . '.';

            if ($route = $configuration->getIndexRoute()) {
                $router->any(
                    $route,
                    [
                        'uses'                                  => 'Anomaly\StreamsModule\Http\Controller\EntriesController@index',
                        'anomaly.module.streams::configuration' => $configuration->getId(),
                        'as'                                    => $prefix . 'index',
                    ]
                );
            }

            if ($route = $configuration->getViewRoute()) {
                $router->any(
                    $route,
                    [
                        'uses'                                  => 'Anomaly\StreamsModule\Http\Controller\EntriesController@view',
                        'anomaly.module.streams::configuration' => $configuration->getId(),
                        'as'                                    => $prefix . 'view',
                    ]
                );
            }
        }
    }
}
