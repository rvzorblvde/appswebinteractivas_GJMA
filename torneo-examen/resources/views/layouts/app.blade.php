<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Torneos') · Hoop Arena</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=barlow-condensed:600,700|inter:400,500,600" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-800 antialiased">

<header x-data="{ open: false }" class="sticky top-0 z-40 bg-slate-900 text-white shadow">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between px-4 py-3">
        <a href="{{ route('torneos.index') }}" class="flex items-center gap-2 font-display text-2xl font-bold tracking-wide">
            <span>🏀</span> HOOP ARENA
        </a>
        <button class="rounded-lg p-2 text-xl md:hidden" @click="open = !open" aria-label="Menú">☰</button>

        <nav :class="open ? 'flex' : 'hidden'"
             class="w-full flex-col gap-3 pt-3 text-sm md:flex md:w-auto md:flex-row md:items-center md:gap-6 md:pt-0">
            <a href="{{ route('torneos.index') }}" class="hover:text-orange-400 {{ request()->routeIs('torneos.*') ? 'text-orange-400' : '' }}">Torneos</a>

            @auth
                @if (auth()->user()->esAdmin())
                    <a href="{{ route('admin.torneos.index') }}" class="hover:text-orange-400 {{ request()->routeIs('admin.*') ? 'text-orange-400' : '' }}">Panel admin</a>
                @else
                    <a href="{{ route('mis-torneos') }}" class="hover:text-orange-400 {{ request()->routeIs('mis-torneos') ? 'text-orange-400' : '' }}">Mis torneos</a>
                @endif
                <span class="text-slate-400">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="rounded-lg bg-white/10 px-3 py-1.5 hover:bg-white/20">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-orange-400">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="rounded-lg bg-orange-500 px-3 py-1.5 font-semibold hover:bg-orange-600">Registrarme</a>
            @endauth
        </nav>
    </div>
</header>

@if (session('success') || session('error'))
    <div class="mx-auto mt-4 w-full max-w-6xl space-y-2 px-4">
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                 class="flex items-start justify-between rounded-xl bg-emerald-50 p-4 text-sm text-emerald-800 ring-1 ring-emerald-200">
                <span>✅ {{ session('success') }}</span>
                <button @click="show = false" aria-label="Cerrar">✕</button>
            </div>
        @endif
        @if (session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show" x-transition
                 class="flex items-start justify-between rounded-xl bg-rose-50 p-4 text-sm text-rose-800 ring-1 ring-rose-200">
                <span>⚠️ {{ session('error') }}</span>
                <button @click="show = false" aria-label="Cerrar">✕</button>
            </div>
        @endif
    </div>
@endif

<main class="mx-auto w-full max-w-6xl flex-1 px-4 py-8">
    @yield('content')
</main>

<footer class="py-6 text-center text-xs text-slate-400">Hoop Arena · Segundo Parcial · Programación Interactiva</footer>
</body>
</html>
