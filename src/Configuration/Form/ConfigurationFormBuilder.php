<?php namespace Anomaly\StreamsModule\Configuration\Form;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ConfigurationFormBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ConfigurationFormBuilder extends FormBuilder
{

    /**
     * The skipped fields.
     *
     * @var string
     */
    protected $skips = [
        'related',
    ];

    /**
     * The related stream.
     *
     * @var StreamInterface
     */
    protected $related;

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
     * Set the related stream.
     *
     * @param StreamInterface $related
     * @return $this
     */
    public function setRelated(StreamInterface $related)
    {
        $this->related = $related;

        return $this;
    }

    /**
     * Fired just before saving.
     */
    public function onSaving()
    {
        if ($related = $this->getRelated()) {
            $this->setFormEntryAttribute('related', $related);
        }
    }

}
