<?php

namespace App\Http\Middleware;

use Closure;

class LoginMiddleware
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
        if($request->session()->exists('user')){
            // 存在用户，可以通过中间件
            return $next($request);
        }else{
            return redirect('home/login');
        }
    }
}
