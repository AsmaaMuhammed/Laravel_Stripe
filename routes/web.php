<?php

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

Auth::routes();
Route::post(
    'stripe/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware'=>['auth']], function (){
    Route::get('/one-charge', 'OneTimePayment@getCharge');
    Route::post('/one-charge', 'OneTimePayment@postCharge');
    Route::get('/recurring-charge', 'RecurringPayment@getCharge');
    Route::post('/recurring-charge', 'RecurringPayment@postCharge');
});

