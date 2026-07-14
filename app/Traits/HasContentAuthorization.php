<?php

namespace App\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


trait HasContentAuthorization
{
    use AuthorizesRequests;

    /**
     * Check permission and return content-only 403 view if unauthorized.
     */
    protected function authorizeContent(string $permission, string $view, array $compact = [])
    {
        try {
            $this->authorize($permission);

            return view($view, $compact);
        } catch (AuthorizationException $e) {
            return view('components.403-error');
        }
    }

    protected function authorizeAction(string $permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(redirect()->back()->with('error', 'You Dont have permissions to Delete'));
        }
    }
}
