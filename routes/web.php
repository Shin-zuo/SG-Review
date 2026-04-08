<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use GuzzleHttp\Middleware;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\ReviewerController;

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
    return view('pages.landing');
})->name('home');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/login',[LoginController::class, 'index'])->name('login');

Route::post('/login/authenticate',[LoginController::class, 'authenticate'])->name('login.authenticate');

Route::middleware(['auth', IsAdmin::class])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/reviewers', [ReviewerController::class, 'index'])->name('reviewers');

});