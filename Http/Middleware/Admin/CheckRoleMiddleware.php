<?php

namespace App\Http\Middleware\Admin;

use App\Models\Permission;
use Closure;
use Illuminate\Support\Facades\Route;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $permissions = Permission::where('role_id', auth()->user()->role_id)->pluck('permission')->toArray();
        if (in_array(Route::currentRouteName(), $permissions)) {
            return $next($request);
        } else {
            session()->flash('danger', 'لا تملك هذه الصلاحية');
            if(!count($permissions)){
                session()->invalidate();
                session()->regenerateToken();
                return redirect(route('admin.login'));
            }
            return redirect(url('admin/dashboard'));
        }
    }
}
