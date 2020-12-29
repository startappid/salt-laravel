<?php

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// DEFAULT: RESOURCES
// ->namespace($this->namespace)
Route::namespace('App\Http\Controllers')->group(function () {

    Route::get("{collection}", 'ResourcesController@index');
    Route::get("{collection}/create", 'ResourcesController@create');
    Route::post("{collection}", 'ResourcesController@store');
    Route::get("{collection}/{id}", 'ResourcesController@show')->where('id', '[0-9]+');
    Route::get("{collection}/{id}/edit", 'ResourcesController@edit')->where('id', '[0-9]+');
    Route::put("{collection}/{id}", 'ResourcesController@update')->where('id', '[0-9]+');
    Route::delete("{collection}/{id}", 'ResourcesController@destroy')->where('id', '[0-9]+');

    Route::get("{collection}/import", 'ResourcesController@import');
    Route::post("{collection}/import", 'ResourcesController@doImport');
    Route::get("{collection}/export", 'ResourcesController@export');
    Route::post("{collection}/export", 'ResourcesController@doExport');

    Route::get("{collection}/trash", 'ResourcesController@trash');
    Route::get("{collection}/{id}/trashed", 'ResourcesController@trashed')->where('id', '[0-9]+');
    Route::put("{collection}/{id}/restore", 'ResourcesController@restore')->where('id', '[0-9]+');
    Route::delete("{collection}/{id}/delete", 'ResourcesController@delete')->where('id', '[0-9]+'); // hard delete item
    Route::delete("{collection}/trash/empty", 'ResourcesController@empty'); // empty all trashed
    Route::put("{collection}/trash/restore", 'ResourcesController@putBack'); // empty all trashed
});


require __DIR__.'/auth.php';
