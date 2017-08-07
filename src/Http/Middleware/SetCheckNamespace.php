<?php namespace Anomaly\StreamsModule\Http\Middleware;

use Anomaly\Streams\Platform\Message\MessageBag;
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
     * The message bag.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * Create a new SetCheckNamespace instance.
     *
     * @param GroupRepositoryInterface $groups
     * @param Store                    $session
     * @param Redirector               $redirect
     * @param MessageBag               $messages
     */
    public function __construct(
        GroupRepositoryInterface $groups,
        Store $session,
        Redirector $redirect,
        MessageBag $messages
    ) {
        $this->groups   = $groups;
        $this->session  = $session;
        $this->redirect = $redirect;
        $this->messages = $messages;
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
        /**
         * Ignore everything this if
         * we're creating a new group.
         */
        if ($request->path() == 'admin/streams/namespaces/create') {

            $this->session->put('anomaly.module.streams::namespace', null);

            return $next($request);
        }

        /* @var GroupInterface $group */
        if (!$namespace = $request->get('namespace', $this->session->get('anomaly.module.streams::namespace'))) {
            $group = $this->groups->first();
        } else {
            $group = $this->groups->findBySlug($namespace);
        }

        /**
         * If we don't have a namespace but
         * we do have a group then update
         * the namespace and redirect.
         */
        if (!$namespace && $group) {

            $this->session->put('anomaly.module.streams::namespace', $group->getSlug());

            return $this->redirect->to($request->path());
        }

        /**
         * If we don't have a namespace or
         * a group then we need to create one.
         */
        if (!$namespace && !$group) {

            $this->messages->info('anomaly.module.streams::message.get_started');

            return $this->redirect->to('admin/streams/namespaces/create');
        }

        /**
         * If we have a namespace but no
         * group then the namespace is old
         * and we need to create a new group.
         */
        if ($namespace && !$group) {

            $this->messages->info('anomaly.module.streams::message.get_started');
            
            return $this->redirect->to('admin/streams/namespaces/create');
        }

        /**
         * If we're good to go and we've got a
         * query string param for namespace then
         * redirect to intended so session sticks.
         */
        if ($namespace && $group && $request->has('namespace')) {

            $this->session->put('anomaly.module.streams::namespace', $group->getSlug());

            return $this->redirect->to($request->path());
        }

        return $next($request);
    }
}
