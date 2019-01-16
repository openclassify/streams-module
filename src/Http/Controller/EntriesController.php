<?php namespace Anomaly\StreamsModule\Http\Controller;

use Anomaly\EditorFieldType\EditorFieldTypePresenter;
use Anomaly\Streams\Platform\Http\Controller\PublicController;
use Anomaly\Streams\Platform\View\ViewTemplate;
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
     * @param ViewTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function index(ConfigurationRepositoryInterface $configurations, ViewTemplate $template)
    {
        /* @var ConfigurationInterface $configuration */
        if (!$configuration = $configurations->find($this->route->getAction('anomaly.module.streams::configuration'))) {
            abort(404);
        }

        // Pass the stream to the template globals.
        $template->set('stream', $stream = $configuration->getRelated());

        /* @var EditorFieldTypePresenter $template */
        $template = $configuration->getFieldTypePresenter('index_template');

        return $this->response->view($template->path(), compact('stream'));
    }

    /**
     * View an entry in the stream.
     *
     * @param ConfigurationRepositoryInterface $configurations
     * @param ViewTemplate $template
     * @return \Illuminate\Http\Response
     */
    public function view(ConfigurationRepositoryInterface $configurations, ViewTemplate $template)
    {
        /* @var ConfigurationInterface $configuration */
        if (!$configuration = $configurations->find($this->route->getAction('anomaly.module.streams::configuration'))) {
            abort(404);
        }

        // Pass the stream to the template globals.
        $template->set('stream', $stream = $configuration->getRelated());

        /* @var EditorFieldTypePresenter $template */
        $template = $configuration->getFieldTypePresenter('view_template');

        return $this->response->view($template->path(), compact('stream'));
    }

}
