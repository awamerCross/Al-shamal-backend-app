<?php

namespace App\Http\Middleware;

use App;
use Closure;
use App\Models\User;
use App\Traits\Responses;
class Provider
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

        if (auth()->user()->user_type == User::PROVIDER) {
           return     $next($request);
        }
          $this->errorResponse([],__('auth.invalid_user'),[],400);
    }
}
