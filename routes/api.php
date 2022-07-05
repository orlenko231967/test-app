<?php

use App\GamesRequestsDirectory\Controllers\GamePrepareController;
use App\GamesRequestsDirectory\Enums\Genre;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   // return $request->user();
//});

Route::controller(GamePrepareController::class)->group(function (){
    Route::get('/games', 'getAll');
    Route::post('/game', 'create');
    Route::get('/game/{game}', 'getOne')->where(['game' => '[0-9]+']);
    Route::put('/game/{game}', 'update')->where(['game' => '[0-9]+']);
    Route::delete('/game/{game}', 'delete')->where(['game' => '[0-9]+']);
    Route::get('/game-genre/{genre}', 'getGenre')->whereIn('genre', Genre::values());
});
