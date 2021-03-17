<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/add-fruit', [ApiController::class, 'addFruit']);
Route::get('/get-fruits', [ApiController::class, 'getFruits']);
Route::post('/search-fruits', [ApiController::class, 'searchFruits']);
Route::post('/edit-fruit', [ApiController::class, 'editFruit']);
Route::post('/delete-fruit', [ApiController::class, 'deleteFruit']);