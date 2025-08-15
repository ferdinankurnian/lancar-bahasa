<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if($request->user()->role !== $role) {
            if($request->user()->role === 'instructor'){
                return redirect()->route('instructor.dashboard');
            }elseif($request->user()->role === 'student'){
                return redirect()->route('student.dashboard');
            }
        }
        return $next($request);
    }
}
