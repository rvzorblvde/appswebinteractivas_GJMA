@extends('layouts.app')
@section('title', 'Crear cuenta')

@section('content')
    <div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow-sm ring-1 ring-stone-200">
        <h1 class="mb-5 text-2xl font-bold">Crear cuenta</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-4" novalidate>
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       class="mt-1 w-full rounded border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400 {{ $errors->has('name') ? 'border-red-500' : 'border-stone-300' }}">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

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

            <div>
                <label for="password_confirmation" class="block text-sm font-medium">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="mt-1 w-full rounded border border-stone-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <button type="submit" class="w-full rounded bg-orange-600 py-2 font-medium text-white hover:bg-orange-700">
                Registrarme
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-stone-600">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-orange-600 hover:underline">Inicia sesión</a>
        </p>
    </div>
@endsection
