<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\CapacitacionAdmin; // Importación correcta del componente
use App\Livewire\Admin\UsuariosAdmin;
use App\Http\Controllers\MisCapacitacionesController; // Asegúrate de que este controlador exista

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
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('/mis-capacitaciones', [MisCapacitacionesController::class, 'index'])->name('mis-capacitaciones');
    Route::delete('/mis-capacitaciones/{capacitacion}', [MisCapacitacionesController::class, 'eliminar'])->name('mis-capacitaciones.eliminar');
});

Route::middleware(['auth', 'can:admin,App\\Models\\User'])->group(function () {
    // Rutas de administración
    Route::get('/admin/capacitaciones', CapacitacionAdmin::class)->name('admin.capacitaciones');
    Route::get('/admin/usuarios', UsuariosAdmin::class)->name('admin.usuarios');
});

Route::get('/sobre-nosotros', function () {
    return view('sobre-nosotros');
})->name('sobre.nosotros');

require __DIR__.'/auth.php';
