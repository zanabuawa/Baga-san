<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\ReferenceController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DiscountCodeController;
use App\Http\Controllers\Admin\ProcessStepController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\MusicTrackController;

// ── Rutas públicas ──
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contacto', [HomeController::class, 'contact'])->name('contacto.store');
Route::post('/descuento/aplicar', [HomeController::class, 'applyDiscount'])->name('descuento.aplicar');

// ── Rutas admin (protegidas) ──
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Portafolio
    Route::resource('portfolio', PortfolioController::class);

    // Comisiones de clientes
    Route::resource('commissions', CommissionController::class);

    // Paquetes de precios
    Route::resource('packages', PackageController::class);

    // Configuración de la página
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

    // Links sociales
    Route::get('social-links', [SocialLinkController::class, 'index'])->name('social-links.index');
    Route::post('social-links', [SocialLinkController::class, 'update'])->name('social-links.update');

    Route::resource('categories', CategoryController::class);

    Route::delete('references/{reference}', [ReferenceController::class, 'destroy'])->name('references.destroy');
    Route::resource('products', ProductController::class);

    // Códigos de descuento
    Route::resource('discount-codes', DiscountCodeController::class);

    // Pasos del proceso
    Route::resource('process-steps', ProcessStepController::class)->except(['show']);

    // FAQ
    Route::resource('faqs', FaqController::class)->except(['show']);

    // Música
    Route::resource('music-tracks', MusicTrackController::class)->except(['show']);

    // Toggle prioridad en comisiones
    Route::post('commissions/{commission}/toggle-priority', [CommissionController::class, 'togglePriority'])->name('commissions.togglePriority');
});

Route::get('/register', function() { abort(404); });
Route::post('/register', function() { abort(404); });

require __DIR__ . '/auth.php';
