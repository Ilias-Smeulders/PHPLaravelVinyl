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

Route::view('/', 'home');
Route::view('contact-us', 'contact');
Route::get('shop', 'ShopController@index');
Route::get('shop/{id}', 'ShopController@show');
Route::get('shop_alt', 'ShopController@alt');
Route::get('itunes', 'ItunesController@index');
Route::view('contact-us', 'contact');
Route::get('contact-us', 'ContactUsController@show');
Route::post('contact-us', 'ContactUsController@sendEmail');
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::redirect('/', '/admin/records');
    Route::resource('genres', 'Admin\GenreController');
    Route::get('genres2/qryGenres', 'Admin\Genre2Controller@qryGenres');
    Route::resource('genres2', 'Admin\Genre2Controller', ['parameters' => ['genres2' => 'genre']]);
    Route::resource('records', 'Admin\RecordController');
    Route::resource('users', 'Admin\UserController');
});
Route::middleware(['auth'])->prefix('users')->group(function () {
    Route::redirect('/', '/users/profile');
    Route::get('profile', 'User\ProfileController@edit');
    Route::post('profile', 'User\ProfileController@update');
    Route::get('password', 'User\PasswordController@edit');
    Route::post('password', 'User\PasswordController@update');
    Route::get('history', 'User\HistoryController@index');
    Route::get('checkout', 'User\HistoryController@checkout');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('basket', 'BasketController@index');
Route::get('basket/add/{id}', 'BasketController@addToCart');
Route::get('basket/delete/{id}', 'BasketController@deleteFromCart');
Route::get('basket/empty', 'BasketController@emptyCart');
Route::get('basket/remove/{id}', 'BasketController@removeRecordFromCart');
