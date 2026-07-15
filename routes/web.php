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
Use App\Models\Reviewer;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GoogleOAuthController;

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
Route::get('/courses', [ReviewerController::class, 'reviewerCourses'])->name('courses');

// Ambassador / Agent Registration Flow
Route::get('/agents/register', [AgentController::class, 'showRegistrationForm'])->name('agents.register');
Route::post('/agents/register', [AgentController::class, 'storeRegistration'])->name('agents.register.store');

// Enrollment Mockup Flow Routes
Route::prefix('enroll')->group(function () {
    Route::get('/status/success', [StudentController::class, 'success'])->name('enroll.success');
    Route::get('/{course}', [StudentController::class, 'showSelection'])->name('enroll.selection');
    Route::post('/{course}/free-trial', [StudentController::class, 'storeFreeTrial'])->name('enroll.free');
    Route::post('/{course}/premium', [StudentController::class, 'storePremium'])->name('enroll.premium');
    Route::post('/{course}/request-extension', [StudentController::class, 'requestExtension'])->name('enroll.extension');
});

// Google Classroom OAuth Callback Route
Route::get('/auth/google/callback', [GoogleOAuthController::class, 'callback'])->name('google.callback');

Route::get('/login',[LoginController::class, 'index'])->name('login');

Route::post('/login/authenticate',[LoginController::class, 'authenticate'])->name('login.authenticate');

Route::middleware([Authenticate::class, IsAdmin::class])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reviewer Routes
    Route::get('/reviewers', [ReviewerController::class, 'index'])->name('reviewers');
    Route::get('/admin/reviewers/create', [ReviewerController::class, 'create'])->name('reviewers.create');
    Route::post('/admin/reviewers', [ReviewerController::class, 'store'])->name('reviewers.store');
    Route::delete('/admin/reviewers/{id}', [ReviewerController::class, 'destroy'])->name('reviewers.destroy');
    Route::get('/admin/reviewers/{id}/edit', [ReviewerController::class, 'edit'])->name('reviewers.edit');
    Route::put('/admin/reviewers/{id}', [ReviewerController::class, 'update'])->name('reviewers.update');

    // Agent Routes
    Route::get('/agents', [AgentController::class, 'index'])->name('agents');
    Route::post('/admin/agents', [AgentController::class, 'storeAdmin'])->name('agents.admin.store');
    Route::get('/admin/agents/{id}/edit', [AgentController::class, 'edit'])->name('agents.edit');
    Route::put('/admin/agents/{id}', [AgentController::class, 'update'])->name('agents.update');
    Route::delete('/admin/agents/{id}', [AgentController::class, 'destroy'])->name('agents.destroy');


    // Student Routes
    Route::get('/students', [StudentController::class, 'index'])->name('students');
    Route::post('/students/{student}/approve', [StudentController::class, 'approvePayment'])->name('students.approve');
    Route::post('/students/{student}/resend-invite', [StudentController::class, 'resendInvite'])->name('students.resend_invite');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::post('/students/{student}/unenroll', [StudentController::class, 'unenroll'])->name('students.unenroll');
    Route::post('/students/{student}/approve-extension', [StudentController::class, 'approveExtension'])->name('students.approve_extension');
    Route::post('/students/{student}/reject-extension', [StudentController::class, 'rejectExtension'])->name('students.reject_extension');

    // Google Classroom OAuth Authorization Initiation Route
    Route::get('/admin/google/auth', [GoogleOAuthController::class, 'redirect'])->name('google.auth');
});


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/agents', [AgentController::class, 'storeRegistration'])->name('agents.store');