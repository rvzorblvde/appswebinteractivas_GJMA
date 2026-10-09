@extends('layouts.app')
@section('title', 'Editar receta')

@section('content')
    <h1 class="mb-5 text-2xl font-bold">Editar receta</h1>
    @include('recipes._form', [
        'action' => route('recetas.update', $recipe),
        'method' => 'PUT',
        'submit' => 'Guardar cambios',
    ])
@endsection
