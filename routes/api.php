<?php
declare(strict_types=1);

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

Route::controller(GamePrepareController::class)
    ->as('api.v1.')
    ->group(function (){
    Route::get('/games', 'getAll')->name('show');
    Route::post('/game', 'create')->name('create');
    Route::get('/game/{game}', 'getOne')->where(['game' => '[0-9]+'])->name('show_one');
    Route::put('/game/{game}', 'update')->where(['game' => '[0-9]+'])->name('update');
    Route::delete('/game/{game}', 'delete')->where(['game' => '[0-9]+'])->name('delete');
    Route::get('/{genre}/games', 'getGenre')->whereIn('genre', Genre::values())->name('genre');
});
