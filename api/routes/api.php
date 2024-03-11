<?php

use App\Http\Controllers\GameSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// v1 routes
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/gamesession/all', [GameSessionController::class, 'getAll']);
    Route::get('/gamesession', [GameSessionController::class, 'getCurrentGame']);
    Route::post('/gamesession', [GameSessionController::class, 'startNewGame']);
    Route::put('/gamesession', [GameSessionController::class, 'makeStep']);
    Route::delete('/gamesession', [GameSessionController::class, 'quitGame']);
});

