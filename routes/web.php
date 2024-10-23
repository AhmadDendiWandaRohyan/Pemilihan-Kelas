<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserImportController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\PageController::class, 'index'])->name('home');

    Route::resource('user', \App\Http\Controllers\UserController::class)
        ->except(['show', 'edit', 'create'])
        ->middleware(['role:admin']);

    Route::delete('user-destroy', [\App\Http\Controllers\UserController::class, 'destroyAll'])
        ->name('user.destroy.all');

    Route::get('profile', [\App\Http\Controllers\PageController::class, 'profile'])
        ->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\PageController::class, 'profileUpdate'])
        ->name('profile.update');

    Route::get('settings', [\App\Http\Controllers\PageController::class, 'settings'])
        ->name('settings.show')
        ->middleware(['role:admin']);
    Route::put('settings', [\App\Http\Controllers\PageController::class, 'settingsUpdate'])
        ->name('settings.update')
        ->middleware(['role:admin']);

    Route::resource('supporting', \App\Http\Controllers\SupportingController::class);

    Route::resource('announcement', \App\Http\Controllers\AnnouncementController::class)
        ->middleware(['role:admin']);

    Route::get('report', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
    
    Route::get('report-admin', [\App\Http\Controllers\ReportController::class, 'admin'])->name('report.admin')->middleware(['role:admin']);

    Route::prefix('paket')->as('paket.')->group(function () {
        Route::resource('pelajaran', \App\Http\Controllers\PelajaranController::class)->middleware(['role:admin']);
        Route::resource('paket-pelajaran', \App\Http\Controllers\PaketController::class);
    });

    Route::post('pick', [\App\Http\Controllers\PaketController::class, 'storePick'])
        ->name('paket.pick.store');

    Route::post('pick-destroy', [\App\Http\Controllers\PaketController::class, 'destroyPick'])
        ->name('paket.pick.destroy');

    Route::post('paket-pelajaran', [\App\Http\Controllers\PaketController::class, 'destroyPackage'])
        ->name('paket.paket-pelajaran.destroy');
    
    Route::post('paket-reset', [\App\Http\Controllers\PaketController::class, 'destroyPicksAll'])
        ->name('paket.paket-pelajaran.reset');

    Route::post('print', [\App\Http\Controllers\PrintController::class, 'printPDF'])
        ->name('print.pdf');
        
    Route::post('print-rekap', [\App\Http\Controllers\PrintController::class, 'reportPDF'])
    ->name('rekap.pdf');

    Route::delete('pick-destroy', [\App\Http\Controllers\PaketController::class, 'destroyPick'])
        ->name('paket.pick.destroy');

    Route::get('import-users', function () {
        return view('import');
    });

    Route::resource('grade', \App\Http\Controllers\GradeController::class)
        ->middleware(['role:admin']);
    
    Route::post('import-users', [\App\Http\Controllers\UserController::class, 'import'])->name('users.import');
});