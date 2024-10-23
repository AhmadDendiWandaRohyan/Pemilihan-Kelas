<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    //  Fungsi redirectTo menentukan rute yang harus diakses jika pengguna tidak terautentikasi. 
    //  Dalam hal ini, pengguna diarahkan ke rute login.
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');  
        }
    }
}
