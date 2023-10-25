<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskProjectGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $workspaceId = getPermissionsTeamId();
        $projectId = getProjectId();

        if ($workspaceId && str_starts_with($request->getPathInfo(), "/api/w/{$workspaceId}/project/{$projectId}/task/")) {
            $paths = array_filter_values(explode('/', $request->getPathInfo()));

            setTaskId($paths[6] ?? null);
        }

        return $next($request);
    }
}
