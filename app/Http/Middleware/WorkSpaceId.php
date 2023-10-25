<?php

namespace App\Http\Middleware;

use App\Models\Workspace;
use Closure;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkSpaceId
{
    protected $auth;

    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (str_starts_with($request->getPathInfo(), '/api/w/')) {
            $paths = array_filter_values(explode('/', $request->getPathInfo()));
            setPermissionsTeamId($paths[2]);

            if ($this->auth->guard('user')->check()) {
                $exists = Workspace::query()->whereId(getPermissionsTeamId())->where(
                    fn ($query) => $query->whereHas('users', fn ($users) => $users->where('id', $this->auth->guard('user')->id()))
                        ->orWhere('user_id', $this->auth->guard('user')->id())
                )->exists();

                error_if(!$exists, Response::HTTP_FORBIDDEN, 'You are not in this workspace');
            }
        }

        return $next($request);
    }
}
