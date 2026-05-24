<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        AuditLogger::log(
            module: 'auth',
            action: 'login',
            eventKey: 'audit.auth.login',
            description: 'İstifadəçi sistemə daxil oldu.'
        );

        if (auth()->user()?->isSuperAdmin()) {
            return redirect('/admin');
        }

        return redirect('/restaurant');
    }

    public function destroy(Request $request): RedirectResponse
    {
        AuditLogger::log(
            module: 'auth',
            action: 'logout',
            eventKey: 'audit.auth.logout',
            description: 'İstifadəçi sistemdən çıxış etdi.'
        );

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
