<?php

use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;


Route::get('/game/{word}', [WordController::class, 'scoreWord']);
