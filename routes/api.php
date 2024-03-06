<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WebController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tasks', [WebController::class, 'index']);
Route::post('tasks/add', [WebController::class, 'store']);
Route::get('tasks/{id}', [WebController::class, 'show']);
Route::put('tasks/update/{id}', [WebController::class, 'update']);
Route::delete('tasks/{id}', [WebController::class, 'destroy']);
Route::get('tasks/status/{status}', [WebController::class, 'filterByStatus']);
