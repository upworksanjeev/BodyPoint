<?php

namespace App\Http\Middleware;

use App\Services\Vault\VaultAccessService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The header and dashboard already hide Vault without `accessVault`. This
 * keeps the same gate on the URL itself.
 */
class EnsureVaultAccess
{
    public function __construct(private readonly VaultAccessService $access)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->access->customerCanAccessVault()) {
            return $next($request);
        }

        return redirect()
            ->route('dashboard')
            ->with('error', 'You do not have access to the Partner Vault.');
    }
}
