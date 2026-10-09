@extends('layouts.app')
@section('title', 'Iniciar sesión')

@section('content')
    <div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow-sm ring-1 ring-stone-200">
        <h1 class="mb-5 text-2xl font-bold">Iniciar sesión</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-4" novalidate>
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="mt-1 w-full rounded border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400 {{ $errors->has('email') ? 'border-red-500' : 'border-stone-300' }}">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium">Contraseña</label>
                <input id="password" type="password" name="password"
                       class="mt-1 w-full rounded border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400 {{ $errors->has('password') ? 'border-red-500' : 'border-stone-300' }}">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" class="rounded border-stone-300"> Recordarme
            </label>

            <button type="submit" class="w-full rounded bg-orange-600 py-2 font-medium text-white hover:bg-orange-700">
                Entrar
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-stone-600">
            ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-orange-600 hover:underline">Regístrate</a>
        </p>
    </div>
@endsection
