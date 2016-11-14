<?php namespace Anomaly\StreamsModule\Http\Middleware;

use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Session\Store;

/**
 * Class AuthorizeNamespace
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AuthorizeNamespace
{

    /**
     * The auth guard.
     *
     * @var Guard
     */
    protected $auth;

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
     * Create a new AuthorizeNamespace instance.
     *
     * @param Guard                    $auth
     * @param GroupRepositoryInterface $groups
     * @param Store                    $session
     * @param Redirector               $redirect
     * @param MessageBag               $messages
     */
    public function __construct(
        Guard $auth,
        GroupRepositoryInterface $groups,
        Store $session,
        Redirector $redirect,
        MessageBag $messages
    ) {
        $this->auth     = $auth;
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
        /* @var UserInterface $user */
        $user = $this->auth->user();

        /* @var GroupInterface $group */
        $group = $this->groups->findBySlug(
            $this->session->get('anomaly.module.streams::namespace', 'streams')
        );

        /**
         * If no group can be found
         * then nothing to protect!
         */
        if (!$group && $request->path() != 'admin/streams/namespaces/create') {

            $this->messages->info('anomaly.module.streams::message.get_started');

            return $this->redirect->to('admin/streams/namespaces/create');
        }

        if (!$group && $request->path() == 'admin/streams/namespaces/create') {
            return $next($request);
        }

        $roles = $group->getAllowedRoles();

        /**
         * Admins can see all!
         */
        if ($user->isAdmin()) {
            return $next($request);
        }

        /**
         * No roles specified.
         */
        if ($roles->isEmpty()) {
            return $next($request);
        }

        /**
         * Do we have any of the roles?
         */
        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }

        return abort(403);
    }
}
