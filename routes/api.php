<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/test/start', [TestController::class, 'startApi']);
Route::get('/test/questions', [TestController::class, 'questionsApi']);
Route::post('/test/answer', [TestController::class, 'saveAnswerApi']);
Route::post('/test/submit', [TestController::class, 'submitApi']);
Route::get('/test/status', [TestController::class, 'statusApi']);
