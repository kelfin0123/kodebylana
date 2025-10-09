<?php

use Illuminate\Support\Facades\Route;

// ==== Import controllers ====
use App\Http\Controllers\Web\{
    HomeController, ProjectController, ServiceController,
    TestimonialController, BlogController, AboutController, ContactController
};
use App\Http\Controllers\Admin\{
    DashboardController, AdminProjectController, AdminServiceController,
    AdminTestimonialController, AdminBlogController, AdminContactController, SettingController
};

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

Route::get('/testimonials', [TestimonialController::class, 'index'])
    ->name('testimonials.index'); // <— layoutmu memanggil ini

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contact.store');

Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('{project:slug}', [ProjectController::class, 'show'])
        ->where('project', '[A-Za-z0-9\-]+')
        ->name('show');
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('{post:slug}', [BlogController::class, 'show'])
        ->where('post', '[A-Za-z0-9\-]+')
        ->name('show');
});

Route::get('/about', [AboutController::class, 'index'])->name('about');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Admin CMS (manual) — aman dari bentrok Filament
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('cms')->as('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('projects', AdminProjectController::class)->except(['show']);
        Route::resource('services', AdminServiceController::class)->except(['show']);
        Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);

        Route::resource('blog', AdminBlogController::class)
            ->parameters(['blog' => 'post'])
            ->except(['show']);

        Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::patch('contacts/{id}/toggle', [AdminContactController::class, 'toggle'])->name('contacts.toggle');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    });

Route::fallback(fn () => abort(404));
