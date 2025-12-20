<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\EventController;
use App\Http\Controllers\Frontend\TeacherController;
use App\Http\Controllers\Frontend\AchievementController;
use App\Http\Controllers\Frontend\DownloadController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\PpdbController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| These routes handle the public-facing school website. All routes are
| scoped to a specific school tenant via the IdentifyTenant middleware.
|
*/

Route::middleware(['tenant'])->group(function () {
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // Posts/Berita
    Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
    Route::get('/berita/{post:slug}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/berita/kategori/{category:slug}', [PostController::class, 'category'])->name('posts.category');
    
    // Events/Agenda
    Route::get('/agenda', [EventController::class, 'index'])->name('events.index');
    Route::get('/agenda/{event:slug}', [EventController::class, 'show'])->name('events.show');
    
    // Teachers/Guru
    Route::get('/guru-staff', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/guru-staff/{teacher:slug}', [TeacherController::class, 'show'])->name('teachers.show');
    
    // Achievements/Prestasi
    Route::get('/prestasi', [AchievementController::class, 'index'])->name('achievements.index');
    
    // Gallery
    Route::get('/galeri', [GalleryController::class, 'index'])->name('galleries.index');
    Route::get('/galeri/{gallery:slug}', [GalleryController::class, 'show'])->name('galleries.show');
    
    // Downloads
    Route::get('/download', [DownloadController::class, 'index'])->name('downloads.index');
    Route::get('/download/{download}', [DownloadController::class, 'download'])->name('downloads.download');
    
    // PPDB
    Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb.index');
    Route::get('/ppdb/daftar', [PpdbController::class, 'create'])->name('ppdb.create');
    Route::post('/ppdb/daftar', [PpdbController::class, 'store'])->name('ppdb.store');
    Route::get('/ppdb/status', [PpdbController::class, 'status'])->name('ppdb.status');
    
    // Contact
    Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');
    
    // Static Pages (catch-all, must be last)
    Route::get('/{page:slug}', [PageController::class, 'show'])->name('pages.show');
});
