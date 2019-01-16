<?php namespace Anomaly\StreamsModule\Stream\Form;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;
use Anomaly\StreamsModule\Configuration\Form\ConfigurationFormBuilder;

/**
 * Class StreamConfigurationFormBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamConfigurationFormBuilder extends MultipleFormBuilder
{

    /**
     * The form section.
     *
     * @var array
     */
    protected $sections = [
        'stream' => [
            'tabs' => [
                'general' => [
                    'title'  => 'anomaly.module.streams::tab.general',
                    'fields' => [
                        'stream_name',
                        'stream_slug',
                        'stream_description',
                        'stream_title_column',
                    ],
                ],
                'options' => [
                    'title'  => 'anomaly.module.streams::tab.options',
                    'fields' => [
                        'stream_translatable',
                        'stream_versionable',
                        'stream_trashable',
                        'stream_sortable',
                        'stream_searchable',
                    ],
                ],
                'routing' => [
                    'title'  => 'anomaly.module.streams::tab.routing',
                    'fields' => [
                        'configuration_index_route',
                        'configuration_index_template',
                        'configuration_view_route',
                        'configuration_view_template',
                    ],
                ],
            ],
        ],
    ];

    /**
     * Don't attach timestamps. This is
     * a core bug fix for the time being.
     * Not sure why this is happening.
     */
    public function onSavingStream()
    {
        $stream = $this->getChildFormEntry('stream');

        $stream->setAttribute('created_at', null);
        $stream->setAttribute('updated_at', null);

        unset($stream['created_at']);
        unset($stream['updated_at']);
    }

    /**
     * Fired after the stream form has saved.
     */
    public function onSavedStream()
    {
        /* @var StreamInterface $stream */
        $stream = $this->getChildFormEntry('stream');

        /* @var ConfigurationFormBuilder $configuration */
        $configuration = $this->getChildForm('configuration');

        $configuration->setRelated($stream);
    }

}
