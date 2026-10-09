<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mis recetas') · Mi Recetario</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-50 text-stone-800 antialiased">

<header class="border-b border-stone-200 bg-white">
    <nav class="mx-auto flex max-w-5xl items-center justify-between px-4 py-3">
        <a href="{{ route('recetas.index') }}" class="text-lg font-bold text-orange-600">🍳 Mi Recetario</a>

        <div class="flex items-center gap-3 text-sm">
            @auth
                <span class="hidden text-stone-500 sm:inline">Hola, {{ auth()->user()->name }}</span>
                <a href="{{ route('recetas.create') }}"
                   class="rounded bg-orange-600 px-3 py-1.5 font-medium text-white hover:bg-orange-700">Nueva receta</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-stone-600 hover:underline">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-stone-600 hover:underline">Iniciar sesión</a>
                <a href="{{ route('register') }}"
                   class="rounded bg-orange-600 px-3 py-1.5 font-medium text-white hover:bg-orange-700">Registrarse</a>
            @endauth
        </div>
    </nav>
</header>

<main class="mx-auto max-w-5xl px-4 py-8">
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
             class="mb-6 flex items-start justify-between rounded border border-green-300 bg-green-50 px-4 py-3 text-green-800">
            <span>{{ session('success') }}</span>
            <button type="button" @click="show = false" class="ml-4 text-green-700" aria-label="Cerrar">✕</button>
        </div>
    @endif

    @yield('content')
</main>

</body>
</html>
