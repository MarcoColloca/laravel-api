<?php
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\Guest\ProjectController as GuestProjectController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});



Route::name('guest.')
->prefix('guest')
->group(function(){
    Route::resource('projects', GuestProjectController::class)->only('index', 'show');
});


Route::middleware(['auth', 'verified'])
->name('admin.') // il prefisso che viene aggiunto a tutti i NOMI delle rotte nel gruppo
->prefix('admin') // il prefisso che viene aggiunto a tutti gli URL delle rotte nel gruppo
->group(function() {

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Registrare tutte le altre rotte protette. Nel nostro caso aggiungeremo la CRUD sui POSTS
    Route::resource('projects', ProjectController::class);
    Route::delete('projects/{project}/forceDestroy', [ProjectController::class, 'forceDestroy'])->name('projects.forceDestroy');
    Route::post('projects/{project}/restore', [ProjectController::class, 'restore'])->name('projects.restore');



    Route::resource('types', TypeController::class);

    Route::resource('technologies', TechnologyController::class);
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
