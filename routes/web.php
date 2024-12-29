<?php

use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\PhoneCodeSendController;
use App\Http\Controllers\TestController;
use App\Http\Livewire\Airplane;
use App\Http\Livewire\Certified;
use App\Http\Livewire\ChangeUserPassword;
use App\Http\Livewire\Contact;
use App\Http\Livewire\CretifiedPassbook;
use App\Http\Livewire\Home;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\Homeoem;
use App\Http\Livewire\MemberCentre;
use App\Http\Livewire\ModifyData;
use App\Http\Livewire\PhoneVerification;
use App\Http\Livewire\TicketOrder;
use App\Http\Livewire\TradeRecord;
use App\Http\Livewire\WithdrawMoney;
use App\Http\Livewire\WithdrawMoneyDetailed;
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

Route::get('/', [PhoneCodeSendController::class, 'emailsend']);
Route::group(['middleware'=> 'neutron-headers'], function(){
    Route::get('/', HomeComponent::class);
    Route::get('/homeoem', Homeoem::class);
    Route::get('/ticketOrder', TicketOrder::class);
    Route::get('/phoneVerification', PhoneVerification::class)->middleware(['auth']);
    Route::get('/airplane', Airplane::class)->middleware(['auth']);
    Route::get('/certified', Certified::class)->middleware(['auth']);
    Route::get('/certifiedPassbook', CretifiedPassbook::class)->middleware(['auth']);
    Route::get('/withdrawMoney', WithdrawMoney::class)->middleware(['auth']);
    Route::get('/memberCentre', MemberCentre::class)->middleware(['auth']);
    Route::get('/tradeRecord', TradeRecord::class)->middleware(['auth']);
    Route::get('/modifyData', ModifyData::class)->middleware(['auth']);
    Route::get('/withdrawMoneyDetailed/{id}', WithdrawMoneyDetailed::class)->middleware(['auth']);
    Route::get('/changeUserPassword', ChangeUserPassword::class)->middleware(['auth']);
    // Route::get('/contact', Contact::class)->middleware(['auth']);

    Route::get('/reload-captcha', [CaptchaController::class, 'reloadCaptcha']);

    Route::post('/test-report', [TestController::class, 'reportChkFn']);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
