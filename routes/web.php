<?php

use App\Http\Controllers\NavigationController;
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

Route::get('/', [NavigationController::class, 'show'])->middleware(['auth', 'verified'])->name('home');
Route::get('/{user}/projects', [NavigationController::class, 'userProjects'])->middleware(['auth', 'verified'])->name('user-projects');
Route::get('/project/{id}', [NavigationController::class, 'project'])->middleware(['auth', 'verified'])->name('project-detail');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
