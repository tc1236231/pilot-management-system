<?php

namespace App\Http\Middleware;

use Closure;

class CheckPilotLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $requiredLevel)
    {
        if(!\Auth::check())
            return abort(401, "未登录");
        if($request->user()->level < $requiredLevel)
            return abort(401, "权限不足");

        return $next($request);
    }
}
