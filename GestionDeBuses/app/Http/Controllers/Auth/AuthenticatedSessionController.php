<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
{
    // Validación de los campos
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
        'role' => ['required', 'in:admin,conductor,pasajero,mantenimiento'], // Validación del rol
    ]);

    // Intentar autenticar al usuario con el email y la contraseña
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();

        // Verificar si el rol seleccionado es el correcto
        if ($user->role === $request->role) {
            // Redirigir a la ruta correspondiente según el rol
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role == 'conductor') {
                return redirect()->route('driver.dashboard');
            } elseif ($user->role == 'pasajero') {
                return redirect()->route('passenger.dashboard');
            } elseif ($user->role == 'mantenimiento') {
                return redirect()->route('maintenance.dashboard');
            }
        } else {
            // Si el rol no coincide, redirigir con error
            Auth::logout();
            return back()->withErrors([
                'role' => 'The selected role does not match your account role.',
            ]);
        }
    }

    return back()->withErrors([
        'email' => 'These credentials do not match our records.',
    ]);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
