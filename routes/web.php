<?php

use App\Models\SessionTrackResponse;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SessionTrackResponseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Homepage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        //TODO: supprimer
        'laravelVersion' => Application::VERSION,
        //TODO: supprimer
        'phpVersion' => PHP_VERSION, //TODO: supprimer
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('session', SessionController::class)
    ->only(['store'])
    ->middleware(['auth']);

Route::resource('session-track-response', SessionTrackResponseController::class)
    ->only(['create', 'store'])
    ->parameters(['session-track-response' => 'your_parameter_name'])
    ->middleware(['auth']);

Route::get('session-track-response/create/{sessionTrack}', [SessionTrackResponseController::class, 'create'])->name('session-track-response.create')->middleware('auth');
Route::post('session-track-response/store', [SessionTrackResponseController::class, 'store'])->name('session-track-response.store')->middleware('auth');




require __DIR__ . '/auth.php';