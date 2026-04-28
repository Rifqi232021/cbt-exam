<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/index.html');
});

// Admin routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/questions', [AdminController::class, 'questions'])->name('admin.questions');
Route::get('/admin/students', [AdminController::class, 'students'])->name('admin.students');
Route::get('/admin/results', [AdminController::class, 'results'])->name('admin.results');

// Test route
Route::get('/test-admin', function () {
    return 'Admin route works';
});

// Test routes
Route::get('/test/start', function () {
    return view('test.welcome');
})->name('test.welcome');

Route::post('/test/start', [TestController::class, 'start'])->name('test.start');
Route::post('/test/submit', [TestController::class, 'submit'])->name('test.submit');