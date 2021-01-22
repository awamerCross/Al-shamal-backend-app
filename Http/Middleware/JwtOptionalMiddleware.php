<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Response;
use App\Traits\Responses;

class JwtOptionalMiddleware
{
    use Responses;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        }
        catch (Exception $e) {
            return $next($request);
        }
        return $next($request);
    }


}
