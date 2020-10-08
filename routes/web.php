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
    return view('layout.master');
})->name('home');

Route::get('upload/info/sepomex',['as' => 'upload.info.index','uses' => 'UploadInfoSepomexController@index']);
Route::post('upload/info/sepomex',['as' => 'upload.info.file','uses' => 'UploadInfoSepomexController@store']);
