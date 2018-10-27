<?php namespace Anomaly\StreamsModule\Http\Controller\Admin;

use Anomaly\StreamsModule\Http\Middleware\SetCheckNamespace;
use Illuminate\Session\Store;

/**
 * Class AssignmentsController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AssignmentsController extends \Anomaly\Streams\Platform\Http\Controller\AssignmentsController
{

    /**
     * The working namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * Create a new StreamsController instance.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->middleware(SetCheckNamespace::class);

        $this->namespace = $session->get('anomaly.module.streams::namespace');

        parent::__construct();
    }
}
