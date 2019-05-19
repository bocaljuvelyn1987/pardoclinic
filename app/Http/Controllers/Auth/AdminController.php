<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    use AuthenticatesUsers;

    protected $guard = 'admin';

    protected $redirectTo = '/clinicdashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.adminlogin');
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

}
