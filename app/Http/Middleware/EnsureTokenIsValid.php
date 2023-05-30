<?php

namespace App\Http\Middleware;

use App\Models\Societies;
use Closure;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if (
            !Societies::where('login_tokens', $token)->exists()
            || $request->bearerToken() !== Societies::where('login_tokens', $token)->first()->login_tokens
        ) {
            return response('Unauthenticated', 401);
        }
        $society = Societies::where('login_tokens', $token)->first();

        return $next($request);
    }
}
