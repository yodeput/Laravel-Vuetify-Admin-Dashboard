<?php

use App\Notifications\MailResetPasswordNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;

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
/*Route::get('/test-mail', function (){
    Notification::route('mail', 'yodeput@gmail.com')->notify(new MailResetPasswordNotification('ksdifjsdifj'));
    return 'Sent';
});*/
Route::get('/{any}', [ApplicationController::class, 'index'])->where('any', '.*');
