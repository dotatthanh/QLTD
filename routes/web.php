<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RevenueController;

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
    return view('auth.login');
});

Route::get('/dashboard', 'App\Http\Controllers\BillController@dashboard')->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['role:admin|staff']], function () {
	Route::resource('bills', BillController::class)->middleware(['auth']);
	Route::get('/customer/{id}/import', 'App\Http\Controllers\BillController@import')->name('import')->middleware(['auth']);
	Route::post('/import-power-number/{id}', 'App\Http\Controllers\BillController@importPowerNumber')->name('import-power-number')->middleware(['auth']);
	Route::resource('customers', CustomerController::class)->middleware(['auth']);
	Route::get('/export-customer', 'App\Http\Controllers\CustomerController@exportCustomer')->name('export-customer')->middleware(['auth']);
	Route::get('/export-bill', 'App\Http\Controllers\BillController@exportBill')->name('export-bill')->middleware(['auth']);
	Route::get('/export-revenue', 'App\Http\Controllers\RevenueController@exportRevenue')->name('export-revenue')->middleware(['auth']);
	Route::post('/print', 'App\Http\Controllers\BillController@print')->name('print')->middleware(['auth']);
	Route::post('/delete-customer/{id}', 'App\Http\Controllers\CustomerController@deleteCustomer')->name('delete-customer')->middleware(['auth']);
});

Route::group(['middleware' => ['role:admin']], function () {
	Route::get('/staff', 'App\Http\Controllers\UserController@staff')->name('staff')->middleware(['auth']);
	Route::post('/active/{id}', 'App\Http\Controllers\UserController@active')->name('active')->middleware(['auth']);
	Route::post('/delete-user/{id}', 'App\Http\Controllers\UserController@deleteUser')->name('delete-user')->middleware(['auth']);
	Route::get('/role', 'App\Http\Controllers\UserController@role')->name('role')->middleware(['auth']);
	Route::get('/role/{id}/edit', 'App\Http\Controllers\UserController@editPermission')->name('edit-permission')->middleware(['auth']);
	Route::post('/role/{id}/update', 'App\Http\Controllers\UserController@updatePermission')->name('update-permission')->middleware(['auth']);
	Route::get('/revenue', 'App\Http\Controllers\RevenueController@revenue')->name('revenue')->middleware(['auth']);
});






Route::get('/change-password', 'App\Http\Controllers\UserController@changePassword')->name('change-password')->middleware(['auth']);
Route::post('/change-password', 'App\Http\Controllers\UserController@changePasswordStore')->name('change-password-store')->middleware(['auth']);


// Route::get('/test', 'App\Http\Controllers\UserController@test');


// Route::group(['middleware' => ['can:delete customer']], function () {
// });







require __DIR__.'/auth.php';
