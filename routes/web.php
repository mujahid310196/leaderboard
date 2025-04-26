<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\LeaderboardController;

Route::get('/leaderboard', [LeaderboardController::class, 'index']);
Route::post('/recalculate', [LeaderboardController::class, 'recalculate'])->name('recalculate');

