<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function showRegister() { return view('auth.register'); }
    public function showLogin() { return view('auth.login'); }

    // Registro de usuarios
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Escribe una dirección de correo válida.',
            'email.unique' => 'Ese correo ya esta registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no son iguales.'
        ]);

        $user = User::create($data + ['role' => 'jugador']);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('torneos.index')->with('success',  'Bienvenido' . $user->name . 'ya puedes inscribirte');
    }

    // Inicio de sesión
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Escribe tu correo.',
            'email.email' => 'Escribe un correo válido.',
            'password.required' => 'Escribe tu contraseña'
        ]);

        // Error en los datos
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Correo o contraseña incorrectos.']);
        }

        // Redirigir a la vista correspondiente
        $request->session()->regenerate();
        $destino = Auth::user()->esAdmin() ? route('admin.torneos.index') : route('torneos.index');

        return redirect()->intended($destino)->with('success', 'Sesión iniciada correctamente.');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('torneos.index')->with('success', 'Sesión terminada.');
    }
}
