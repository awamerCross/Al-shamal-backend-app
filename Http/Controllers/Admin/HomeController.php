<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /***************** dashboard *****************/
    public function dashboard()
    {
    
        return view('admin.dashboard.index');
    }
}
