<?php namespace Anomaly\StreamsModule\Http\Middleware;

use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Session\Store;

/**
 * Class SetCheckNamespace
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetCheckNamespace
{

    /**
     * The group repository.
     *
     * @var GroupRepositoryInterface
     */
    protected $groups;

    /**
     * The session store.
     *
     * @var Store
     */
    protected $session;

    /**
     * The redirect utility.
     *
     * @var Redirector
     */
    protected $redirect;

    /**
     * Create a new SetCheckNamespace instance.
     *
     * @param Store                    $session
     * @param Redirector               $redirect
     * @param GroupRepositoryInterface $groups
     */
    public function __construct(Store $session, Redirector $redirect, GroupRepositoryInterface $groups)
    {
        $this->groups   = $groups;
        $this->session  = $session;
        $this->redirect = $redirect;
    }

    /**
     * Check for and set namespace if present.
     *
     * @param  Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($namespace = $request->get('namespace')) {

            $this->session->set('anomaly.module.streams::namespace', $namespace);

            return $this->redirect->to($request->path());
        }

        /* @var GroupInterface $namespace */
        if (!$this->session->get('anomaly.module.streams::namespace') && $namespace = $this->groups->first()) {

            $this->session->set('anomaly.module.streams::namespace', $namespace->getSlug());

            return $this->redirect->to($request->path());
        }

        return $next($request);
    }
}
