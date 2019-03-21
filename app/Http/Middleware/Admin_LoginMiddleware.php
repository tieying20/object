<?php

namespace App\Http\Middleware;

use Closure;

class Admin_LoginMiddleware
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
        if($request->session()->exists('admin')){
            // 存在用户，可以通过中间件
            return $next($request);
        }else{
            return redirect('admin/login');
        }
    }
}
