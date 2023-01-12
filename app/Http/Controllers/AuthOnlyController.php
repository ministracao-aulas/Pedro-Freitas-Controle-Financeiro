<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthOnlyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke()
    {
        return static::dashboardOrLogin();
    }

    /**
     * function dashboardOrLogin
     *
     * @return mixed
     */
    public static function dashboardOrLogin()
    {
        if (!Auth::guest()) {
            return redirect()->route('login');
        }

        return redirect()->route('admin.dashboard');
    }
}
