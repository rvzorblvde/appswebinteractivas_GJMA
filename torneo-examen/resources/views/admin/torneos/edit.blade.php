@extends('layouts.app')
@section('title', 'Editar torneo')
@section('content')
    <div class="card mx-auto max-w-3xl" data-animate="fade-up">
        <h1 class="mb-6 font-display text-3xl font-bold">Editar torneo</h1>
        @include('admin.torneos._form', ['torneo' => $torneo, 'action' => route('admin.torneos.update', $torneo)])
    </div>
@endsection
