<?php

namespace App\Http\Middleware;

use   App;
use   Closure;
use   App\Models\User;
use   Carbon\Carbon;
use   App\Traits\Expo ;
class localization
{
    use Expo;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (request('lang')) {
            /** Set Lang **/
            request('lang') == 'en' ? App::setLocale('en')    : App::setLocale('ar');
            /** Set Carbon Language **/
            request('lang') == 'en' ? Carbon::setLocale('en') : Carbon::setLocale('ar');
            if (auth()->user() && auth()->user()->block == 1) {
                $user = auth()->user() ;
                $this->sendExpoNotify($user, ['title' => 'حظر'  , 'body' => 'تم حظرك من قبل الاداره' ,'type' => 'block']);
            }
            return $next($request);
        }

        if (auth()->user()) {
            $user          = User::whereId(auth()->user())->first();

            if ($user) {
                App        ::setLocale(request('lang'));
                Carbon     ::setLocale(request('lang'));
                if (auth()->user()->block == 1) {
                    $this->sendExpoNotify(auth()->user(), ['title' => 'حظر'  , 'body' => 'تم حظرك من قبل الاداره' ,'type' => 'block']);
                }
                return     $next($request);
            }
        }
        if (auth()->user() && auth()->user()->block == 1) {
            $this->sendExpoNotify(auth()->user(), ['title' => 'حظر'  , 'body' => 'تم حظرك من قبل الاداره' ,'type' => 'block']);
        }
        App                 ::setLocale('ar');
        Carbon              ::setLocale('ar');
        return $next($request);
    }
}
