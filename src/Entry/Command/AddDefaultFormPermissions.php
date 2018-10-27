<?php namespace Anomaly\StreamsModule\Entry\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;

/**
 * Class AddDefaultFormPermissions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddDefaultFormPermissions
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * The group instance.
     *
     * @var GroupInterface
     */
    protected $group;

    /**
     * The stream instance.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new AddDefaultFormPermissions instance.
     *
     * @param FormBuilder $builder
     * @param GroupInterface $group
     * @param StreamInterface $stream
     */
    public function __construct(FormBuilder $builder, GroupInterface $group, StreamInterface $stream)
    {
        $this->builder = $builder;
        $this->group   = $group;
        $this->stream  = $stream;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {

        /**
         * Set the permissions for table.
         */
        $this->builder->setOption(
            'permission',
            $this->builder->getOption(
                'permission',
                'anomaly.module.' . $this->group->getSlug() . '::' . $this->stream->getSlug() . '.write'
            )
        );
    }

}
