<?php

namespace App\Http\Middleware;

use Closure;

class AbortIfNotOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $resourceName
     * @return mixed
     */
    public function handle($request, Closure $next, $resourceName)
    {
        $resource = $request->route()->parameter($resourceName);
        $user_id = $resource->user_id;

        if ($request->user()->id != $user_id) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
