@extends('layouts.app')
@section('title', 'Nuevo torneo')
@section('content')
    <div class="card mx-auto max-w-3xl" data-animate="fade-up">
        <h1 class="mb-6 font-display text-3xl font-bold">Nuevo torneo</h1>
        @include('admin.torneos._form', ['action' => route('admin.torneos.store')])
    </div>
@endsection
