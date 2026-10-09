@extends('layouts.app')
@section('title', 'Iniciar sesión')
@section('content')
    <div class="mx-auto max-w-md" data-animate="fade-up">
        <div class="card">
            <h1 class="font-display text-3xl font-bold">Iniciar sesión</h1>
            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4" novalidate>
                @csrf
                <x-campo name="email" label="Correo electrónico" type="email" autofocus />
                <x-campo name="password" label="Contraseña" type="password" />
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" class="rounded"> Recordarme</label>
                <button class="btn-primary w-full">Entrar</button>
            </form>
            <p class="mt-4 text-center text-sm text-slate-500">¿No tienes cuenta? <a href="{{ route('register') }}" class="font-semibold text-orange-600">Regístrate</a></p>
        </div>
    </div>
@endsection
