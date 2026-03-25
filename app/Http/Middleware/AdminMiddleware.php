<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->rol === 'admin' || Auth::user()->uyelik_tipi === 'admin')) {
            return $next($request);
        }

        return redirect()->route('admin.login')
            ->withErrors(['email' => 'Admin yetkisine sahip olmalısınız.']);
    }
}