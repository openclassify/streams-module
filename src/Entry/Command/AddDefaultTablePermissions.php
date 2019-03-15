<?php namespace Anomaly\StreamsModule\Entry\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;

/**
 * Class AddDefaultTablePermissions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddDefaultTablePermissions
{

    /**
     * The table builder.
     *
     * @var TableBuilder
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
     * Create a new AddDefaultTablePermissions instance.
     *
     * @param TableBuilder $builder
     * @param GroupInterface $group
     * @param StreamInterface $stream
     */
    public function __construct(TableBuilder $builder, GroupInterface $group, StreamInterface $stream)
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
                'anomaly.module.' . $this->group->getSlug() . '::' . $this->stream->getSlug() . '.read'
            )
        );

        /**
         * Unless it's a default
         * table skip the rest.
         */
        if ($this->builder->getOption('is_default') !== true) {
            return;
        }

        /**
         * Set the permissions for default buttons.
         */
        $buttons = $this->builder->getButtons();

        if (is_array($buttons) && isset($buttons['edit']) && !isset($buttons['edit']['permission'])) {
            $buttons['edit']['permissions'] = 'anomaly.module.' .
                $this->group->getSlug() . '::' .
                $this->stream->getSlug() . '.write';
        }

        $this->builder->setButtons($buttons);

        /**
         * Set the permissions for default actions.
         */
        $actions = $this->builder->getActions();

        if (is_array($actions) && isset($actions['delete']) && !isset($actions['delete']['permission'])) {
            $actions['edit']['permissions'] = 'anomaly.module.' .
                $this->group->getSlug() . '::' .
                $this->stream->getSlug() . '.delete';
        }

        if (is_array($actions) && isset($actions['delete']) && !isset($actions['delete']['permission'])) {
            $actions['edit']['permissions'] = 'anomaly.module.' .
                $this->group->getSlug() . '::' .
                $this->stream->getSlug() . '.write';
        }

        $this->builder->setActions($actions);
    }

}
