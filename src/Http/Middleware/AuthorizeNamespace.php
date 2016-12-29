<?php namespace Anomaly\StreamsModule\Http\Middleware;

use Anomaly\StreamsModule\Group\Contract\GroupInterface;
use Anomaly\StreamsModule\Group\Contract\GroupRepositoryInterface;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
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
     * Create a new AuthorizeNamespace instance.
     *
     * @param Guard                    $auth
     * @param GroupRepositoryInterface $groups
     * @param Store                    $session
     */
    public function __construct(
        Guard $auth,
        GroupRepositoryInterface $groups,
        Store $session
    ) {
        $this->auth    = $auth;
        $this->groups  = $groups;
        $this->session = $session;
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
        $group = $this->groups->findBySlug($namespace = $this->session->get('anomaly.module.streams::namespace'));

        if (!$group && $request->path() == 'admin/streams/namespaces/create') {
            return $next($request);
        }

        if (!$group) {
            throw new \Exception("Group not found with namespace [{$namespace}]");
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
