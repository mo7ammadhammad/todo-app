<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
public function handle(Request $request, \Closure $next)
{
    if (!session()->has('firebase_user_id')) {
        return redirect('/auth')->withErrors(['error' => 'الرجاء تسجيل الدخول أولاً.']);
    }
    return $next($request);
}
}
