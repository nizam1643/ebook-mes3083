<?php

use App\Http\Controllers\AdminAuthorListController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminHouseholdIncomeController;
use App\Http\Controllers\AdminPackageController;
use App\Http\Controllers\AuthorBookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthorPaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Auth::routes([
        'register' => true,
        'reset' => false,
        'verify' => false,
    ]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'isRoleAuthor'])->prefix('author')->as('author.')->group(function () {
    Route::controller(AuthorController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/createForm', 'createForm')->name('createForm');
        Route::post('/storeForm', 'storeForm')->name('storeForm');
        Route::get('/editForm', 'editForm')->name('editForm');
        Route::put('/updateForm', 'updateForm')->name('updateForm');
        Route::put('/updateUser', 'updateUser')->name('updateUser');

        Route::get('/createFormPdf', 'createFormPdf')->name('createFormPdf');
        Route::get('/uploadImage', 'uploadImage')->name('uploadImage');
    });

    Route::controller(AuthorPaymentController::class)->group(function () {
        Route::get('/payment/{plan}', 'payment')->name('payment');
        Route::get('/payment-redirect', 'paymentRedirect')->name('paymentRedirect');
        Route::get('/payment-history', 'paymentHistory')->name('paymentHistory');
    });

    Route::controller(AuthorBookController::class)->prefix('book')->as('book.')->group(function () {
        Route::get('/createBook', 'createBook')->name('createBook');
        Route::post('/storeBook', 'storeBook')->name('storeBook');
        Route::get('/editBook/{id}', 'editBook')->name('editBook');
        Route::put('/updateBook/{id}', 'updateBook')->name('updateBook');
        Route::delete('/deleteBook/{id}', 'deleteBook')->name('deleteBook');
        Route::post('/publishBook/{id}', 'publishBook')->name('publishBook');

        Route::get('/draftPdf/{id}', 'draftPdf')->name('draftPdf');
        Route::post('/importImage', 'importImage')->name('importImage');
        Route::get('/viewPdf/{id}', 'viewPdf')->name('viewPdf');
        Route::get('/downloadEpub/{id}', 'downloadEpub')->name('downloadEpub');
    });
});

Route::middleware(['auth', 'isRoleAdmin'])->prefix('admin')->as('admin.')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
    });

    Route::controller(AdminPackageController::class)->prefix('package')->as('package.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::controller(AdminHouseholdIncomeController::class)->prefix('income')->as('income.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::controller(AdminAuthorListController::class)->prefix('author')->as('author.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
    });
});