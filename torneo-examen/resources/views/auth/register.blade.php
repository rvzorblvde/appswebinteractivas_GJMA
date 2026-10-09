@extends('layouts.app')
@section('title', 'Registro')
@section('content')
    <div class="mx-auto max-w-md" data-animate="fade-up">
        <div class="card">
            <h1 class="font-display text-3xl font-bold">Crear cuenta de jugador</h1>
            <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4" novalidate>
                @csrf
                <x-campo name="name" label="Nombre" autofocus />
                <x-campo name="email" label="Correo electrónico" type="email" />
                <x-campo name="password" label="Contraseña (mínimo 8 caracteres)" type="password" />
                <x-campo name="password_confirmation" label="Confirmar contraseña" type="password" />
                <button class="btn-primary w-full">Registrarme</button>
            </form>
            <p class="mt-4 text-center text-sm text-slate-500">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="font-semibold text-orange-600">Inicia sesión</a></p>
        </div>
    </div>
@endsection
