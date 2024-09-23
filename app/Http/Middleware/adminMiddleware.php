<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($request->user->role);
        if( $request->user()->role->name == "admin" || $request->user()->role->name == "superadmin"){
            return $next($request);
        }else{
            return response()->json([
                "message"=> "this feature admin can only accept!"
            ],403);
        }
    }
}
