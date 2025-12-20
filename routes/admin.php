<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Routes for the school admin panel. All routes require authentication
| and tenant middleware.
|
*/

Route::middleware(['auth', 'tenant'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Posts (Berita)
    Route::resource('posts', Admin\PostController::class);
    Route::post('posts/{post}/toggle-publish', [Admin\PostController::class, 'togglePublish'])->name('posts.toggle-publish');
    Route::post('posts/{post}/toggle-pin', [Admin\PostController::class, 'togglePin'])->name('posts.toggle-pin');

    // Categories
    Route::resource('categories', Admin\CategoryController::class);

    // Events (Kalender)
    Route::resource('events', Admin\EventController::class);

    // Teachers (Guru & Staff)
    Route::resource('teachers', Admin\TeacherController::class);
    Route::post('teachers/reorder', [Admin\TeacherController::class, 'reorder'])->name('teachers.reorder');

    // Achievements (Prestasi)
    Route::resource('achievements', Admin\AchievementController::class);

    // Galleries
    Route::resource('galleries', Admin\GalleryController::class);
    Route::post('galleries/{gallery}/items', [Admin\GalleryController::class, 'storeItem'])->name('galleries.items.store');
    Route::delete('galleries/{gallery}/items/{item}', [Admin\GalleryController::class, 'destroyItem'])->name('galleries.items.destroy');

    // Downloads
    Route::resource('downloads', Admin\DownloadController::class);

    // Pages (Halaman)
    Route::resource('pages', Admin\PageController::class);

    // PPDB Periods
    Route::resource('ppdb-periods', Admin\PpdbPeriodController::class);

    // PPDB Registrations
    Route::resource('ppdb-registrations', Admin\PpdbRegistrationController::class)->except(['create', 'store']);
    Route::post('ppdb-registrations/{registration}/update-status', [Admin\PpdbRegistrationController::class, 'updateStatus'])->name('ppdb-registrations.update-status');
    Route::get('ppdb-registrations/export', [Admin\PpdbRegistrationController::class, 'export'])->name('ppdb-registrations.export');

    // Menus
    Route::resource('menus', Admin\MenuController::class);
    Route::post('menus/reorder', [Admin\MenuController::class, 'reorder'])->name('menus.reorder');

    // Contact Messages
    Route::resource('contacts', Admin\ContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::post('contacts/{contact}/toggle-read', [Admin\ContactMessageController::class, 'toggleRead'])->name('contacts.toggle-read');

    // Users
    Route::resource('users', Admin\UserController::class);

    // Settings
    Route::get('settings', [Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [Admin\SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/logo', [Admin\SettingsController::class, 'updateLogo'])->name('settings.logo');
    Route::post('settings/banner', [Admin\SettingsController::class, 'updateBanner'])->name('settings.banner');
});
