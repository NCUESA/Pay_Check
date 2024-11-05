<?php

namespace App\Http\Middleware;

use App\Models\AuthIp;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientIp = $request->ip();

        $isAllowed = AuthIp::where('ip_address', $clientIp)
            ->exists();


        if (!$isAllowed) {
            return redirect()->to('/');
        }
        session(['hasAccess' => true]);
        
        return $next($request);
    }
}
