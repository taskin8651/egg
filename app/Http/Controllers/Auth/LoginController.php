<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/'; // ye ignore ho jayega authenticated() ke baad

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // 🔥 ROLE BASED REDIRECT
    protected function authenticated($request, $user)
    {
        if ($user->role_id == 1) {
            return redirect('/admin/dashboard');
        }

        return redirect('/user/dashboard');
    }
}