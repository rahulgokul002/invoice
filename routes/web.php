<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
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
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');
Route::get('/invoice','InvoiceController@index');
Route::get('/dashboard','InvoiceController@index')->middleware(['auth'])->name('dashboard');
Route::get('/invoice/{inv}/edit', 'InvoiceController@edit');
Route::post('/invoice', 'InvoiceController@store');
Route::delete('invoice/destroy/{inv}', 'InvoiceController@destroy');

require __DIR__.'/auth.php';
