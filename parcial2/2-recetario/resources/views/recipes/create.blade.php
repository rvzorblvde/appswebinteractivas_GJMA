@extends('layouts.app')
@section('title', 'Nueva receta')

@section('content')
    <h1 class="mb-5 text-2xl font-bold">Nueva receta</h1>
    @include('recipes._form', [
        'action' => route('recetas.store'),
        'method' => 'POST',
        'submit' => 'Guardar receta',
    ])
@endsection
