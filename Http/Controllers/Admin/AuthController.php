<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /***************** show login form *****************/
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**************** show login form *****************/
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required|string',
        ]);

        $remember = $request->remember == 1 ? true : false;
        if (auth()->guard()->attempt(['email' => $request->email, 'password' => $request->password], $remember))
            return redirect()->route('admin.dashboard');
        else
            return redirect()->route('admin.show.login')->withErrors('تحقق من صحة البيانات المدخلة');

    }

    /**************** logout *****************/
    public function logout()
    {
        auth()->guard()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect(route('admin.login'));
    }
}
