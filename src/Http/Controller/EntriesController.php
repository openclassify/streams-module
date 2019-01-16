<?php namespace Anomaly\StreamsModule\Http\Controller;

use Anomaly\EditorFieldType\EditorFieldTypePresenter;
use Anomaly\Streams\Platform\Http\Controller\PublicController;
use Anomaly\StreamsModule\Configuration\Contract\ConfigurationInterface;
use Anomaly\StreamsModule\Configuration\Contract\ConfigurationRepositoryInterface;

/**
 * Class EntriesController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EntriesController extends PublicController
{

    /**
     * List entries in the stream.
     *
     * @param ConfigurationRepositoryInterface $configurations
     * @return \Illuminate\Http\Response
     */
    public function index(ConfigurationRepositoryInterface $configurations)
    {
        /* @var ConfigurationInterface $configuration */
        if (!$configuration = $configurations->find($this->route->getAction('anomaly.module.streams::configuration'))) {
            abort(404);
        }

        /* @var EditorFieldTypePresenter $template */
        $template = $configuration->getFieldTypePresenter('index_template');

        return $this->response->view(
            $template->path(),
            [
                'stream' => $configuration->getRelated(),
            ]
        );
    }

    /**
     * View an entry in the stream.
     *
     * @param ConfigurationRepositoryInterface $configurations
     * @return \Illuminate\Http\Response
     */
    public function view(ConfigurationRepositoryInterface $configurations)
    {
        /* @var ConfigurationInterface $configuration */
        if (!$configuration = $configurations->find($this->route->getAction('anomaly.module.streams::configuration'))) {
            abort(404);
        }

        /* @var EditorFieldTypePresenter $template */
        $template = $configuration->getFieldTypePresenter('view_template');

        return $this->response->view(
            $template->path(),
            [
                'stream' => $configuration->getRelated(),
            ]
        );
    }

}
