<?php

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Event\AwardCategoryController;
use App\Http\Controllers\Admin\Event\AwardController;
use App\Http\Controllers\Admin\Event\ExpoController;
use App\Http\Controllers\Admin\Event\MarathonController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\Payment\DpoController;
use App\Http\Controllers\Admin\Settings\PaymentSettingController;
use App\Http\Controllers\Admin\Settings\SettingController;
use App\Http\Controllers\Admin\Settings\SiteController;
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\Admin\User\ProfileController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Web\Event\AwardController as EventAwardController;
use App\Http\Controllers\Web\Event\ExpoController as EventExpoController;
use App\Http\Controllers\Web\Event\MarathonController as EventMarathonController;
use App\Http\Controllers\Web\Event\VoteController;
use App\Http\Controllers\Web\WebController;
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

Route::get('/mail', function () {
    return view('emails.nomination');
})->name('email.welcome');
Auth::routes(['verify' => true]);

//Front End Route
Route::group(['as' => 'web.'], function () {
    Route::get('/', [WebController::class, 'index'])->name('index');
    Route::get('/about-us', [WebController::class, 'aboutUs'])->name('aboutUs');
    Route::get('/sponsorship', [WebController::class, 'sponsorship'])->name('sponsorship');
    Route::get('/contact-us', [WebController::class, 'ContactUs'])->name('contactUs');
    Route::get('/refund-policy', [WebController::class, 'refundPolicy'])->name('refund.policy');
    Route::get('/privacy-policy', [WebController::class, 'privacyPolicy'])->name('privacy.policy');
    Route::post('/subscribe', [WebController::class, 'subscribe'])->name('subscribe');
    Route::get('/gallery', [WebController::class, 'gallery'])->name('gallery');
    Route::post('/contact-us', [WebController::class, 'contactUsStore'])->name('contactUs.store');
    Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
        Route::group(['prefix' => 'award', 'as' => 'award.'], function () {
            Route::get('/registration', [EventAwardController::class, 'registration'])->name('registration');
            Route::get('/category', [EventAwardController::class, 'category'])->name('category.index');
            Route::get('/category/{tag:slug}', [EventAwardController::class, 'categoryShow'])->name('category.show');
        });
        Route::resource('award', EventAwardController::class);
        Route::group(['prefix' => 'expo', 'as' => 'expo.'], function () {
            Route::get('/registration', [EventExpoController::class, 'registration'])->name('registration');
        });
        Route::resource('expo', EventExpoController::class);
        Route::group(['prefix' => 'marathon', 'as' => 'marathon.'], function () {
            Route::get('/registration', [EventMarathonController::class, 'registration'])->name('registration');
        });
        Route::resource('marathon', EventMarathonController::class);
        Route::resource('vote', VoteController::class);
    });
    Route::get('/callback', [WebController::class, 'callback'])->name('callback');
    Route::get('/canceled', [WebController::class, 'canceled'])->name('canceled');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::resource('dashboard', DashboardController::class);
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::resource('profile', ProfileController::class);
    });
    Route::resource('messages', MessageController::class);

    Route::group(['prefix' => 'award', 'as' => 'award.'], function () {
        Route::delete('category/destroy/all', [AwardCategoryController::class, 'destroyAll'])->name('category.destroy.all');
        Route::resource('category', AwardCategoryController::class);
        Route::get('winners/{id}', [AwardController::class, 'awardsWinners'])->name('winner.index');
        Route::get('settings', [AwardController::class, 'settingIndex'])->name('setting.index');
        Route::post('settings', [AwardController::class, 'settingStore'])->name('setting.store');
        Route::delete('destroy-all', [AwardController::class, 'destroyAll'])->name('destroy.all');
    });
    Route::resource('award', AwardController::class);
    Route::group(['prefix' => 'marathon', 'as' => 'marathon.'], function () {
        Route::get('runners/{id}', [MarathonController::class, 'runners'])->name('runners');
        Route::delete('destroy-all', [MarathonController::class, 'destroyAll'])->name('destroy.all');
        Route::get('settings', [MarathonController::class, 'settingIndex'])->name('setting.index');
        Route::post('settings', [MarathonController::class, 'settingStore'])->name('setting.store');
    });
    Route::resource('marathon', MarathonController::class);
    Route::group(['prefix' => 'expo', 'as' => 'expo.'], function () {
        Route::delete('destroy-all', [ExpoController::class, 'destroyAll'])->name('destroy.all');
        Route::get('settings', [ExpoController::class, 'settingIndex'])->name('setting.index');
        Route::post('settings', [ExpoController::class, 'settingStore'])->name('setting.store');
    });
    Route::resource('expo', ExpoController::class);
    Route::group(['prefix' => 'gallery', 'as' => 'gallery.'], function () {
        Route::delete('destroy-all', [GalleryController::class, 'destroyAll'])->name('destroy.all');
    });
    Route::resource('gallery', GalleryController::class);
    Route::resource('partner', PartnerController::class);
    Route::resource('mail', MailController::class);
    Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
        Route::group(['prefix' => 'dpo', 'as' => 'dpo.'], function () {
            Route::post('verify-peyment', [DpoController::class, 'verify'])->name('verify');
        });
        Route::resource('dpo', DpoController::class);
    });
    Route::group(['prefix' => 'subscribe', 'as' => 'subscribe.'], function () {
        Route::delete('destroy-all', [SubscribeController::class, 'destroyAll'])->name('destroy.all');
    });
    Route::resource('subscribe', SubscribeController::class);
    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
        Route::delete('destroy-all', [ContactController::class, 'destroyAll'])->name('destroy.all');
    });
    Route::resource('contact', ContactController::class);
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('role-permission', [UsersController::class, 'rolePermision'])->name('role.permision');
    });
    Route::resource('users', UsersController::class);
    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::resource('site', SiteController::class);
        Route::resource('payment', PaymentSettingController::class);
    });
});
