<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use GuzzleHttp\Middleware;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\ReviewerController;
use App\Models\Course;

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
    // Fetch all courses, newest first
    $courses = Course::latest()->get(); 
    
    // Pass them to the landing page
    return view('pages.landing', compact('courses')); 
})->name('home');


Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/login',[LoginController::class, 'index'])->name('login');

Route::post('/login/authenticate',[LoginController::class, 'authenticate'])->name('login.authenticate');

Route::middleware(['auth', IsAdmin::class])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/reviewers', [ReviewerController::class, 'index'])->name('reviewers');

    Route::get('/admin/reviewers/create', [ReviewerController::class, 'create'])->name('reviewers.create');
    Route::post('/admin/reviewers', [ReviewerController::class, 'store'])->name('reviewers.store');
    Route::delete('/admin/reviewers/{id}', [ReviewerController::class, 'destroy'])->name('reviewers.destroy');
    Route::get('/admin/reviewers/{id}/edit', [ReviewerController::class, 'edit'])->name('reviewers.edit');
    Route::put('/admin/reviewers/{id}', [ReviewerController::class, 'update'])->name('reviewers.update');

});


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');