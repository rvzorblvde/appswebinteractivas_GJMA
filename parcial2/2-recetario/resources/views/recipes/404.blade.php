@extends('layouts.app')
@section('title', 'No encontrado')

@section('content')
    <div class="rounded-lg bg-white p-10 text-center shadow-sm ring-1 ring-stone-200">
        <h1 class="text-2xl font-bold">404 · Página no encontrada</h1>
        <p class="mt-2 text-stone-600">El recurso que buscas no existe o no tienes acceso a él.</p>
        <a href="{{ url('/') }}" class="mt-4 inline-block text-orange-600 hover:underline">Volver al inicio</a>
    </div>
@endsection
