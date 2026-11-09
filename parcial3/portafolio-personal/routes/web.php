<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingPage;
use App\Livewire\Experiencia;
use App\Livewire\Proyectos;

Route::get('/', LandingPage::class);
Route::get('/experiencia', Experiencia::class);
Route::get('/proyectos', Proyectos::class);
