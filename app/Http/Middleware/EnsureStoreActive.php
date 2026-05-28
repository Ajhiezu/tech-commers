<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStoreActive
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $store = $request->user()->store;
        
        if (!$store) {
            return redirect()->route('seller.onboarding.index');
        }
        
        if ($store->status === 'pending') {
            return redirect()->route('seller.onboarding.pending');
        }
        
        if ($store->status === 'suspended' || $store->status === 'rejected') {
            return redirect()->route('seller.onboarding.rejected');
        }

        return $next($request);
    }
}
