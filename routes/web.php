<?php
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
// Route::get('/', function () {return view('welcome');})->name('welcome');
Route::get('/verify-pay', [App\Http\Controllers\FrontController::class, 'verify_payment'])->name('verify_payment');
Route::get('/get-balance', [App\Http\Controllers\FrontController::class, 'getBalance'])->name('getBalance');



    Route::get('/mail', function () {return view('emails.nomination');})->name('email.welcome');
    Auth::routes();
    Auth::routes(['verify' => true]);
    Route::post('loginWithOtp', [App\Http\Controllers\Auth\LoginController::class, 'loginWithOtp'])->name('loginWithOtpview');
    Route::get('loginWithOtp', [App\Http\Controllers\Auth\LoginController::class, 'loginpage'])->name('loginWithOtp');
    Route::post('sendOtp', [App\Http\Controllers\Auth\LoginController::class, 'sendOtp'])->name('sendOtp');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/payment', [App\Http\Controllers\HomeController::class, 'payment'])->name('payment');
    Route::get('/callback', [App\Http\Controllers\FrontController::class, 'callback'])->name('callback');
    Route::get('/canceled', [App\Http\Controllers\FrontController::class, 'canceled'])->name('canceled');
    //Front End Route
    Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('index');
    Route::get('/about', [App\Http\Controllers\FrontController::class, 'about'])->name('about');
    Route::get('/sponsorship', [App\Http\Controllers\FrontController::class, 'sponsorship'])->name('sponsorship');
    Route::get('/sponsorship/packages', [App\Http\Controllers\FrontController::class, 'sponsorship_packages'])->name('sponsorship.packages');
    Route::get('/sponsorship/packages/order', [App\Http\Controllers\FrontController::class,'package_order_view'])->name('package_order_view');
    Route::post('/sponsorship/packages/order', [App\Http\Controllers\FrontController::class,'order_store'])->name('order_store');
    Route::get('/registration', [App\Http\Controllers\FrontController::class, 'registration'])->name('registration');
    // Route::get('/registration/invoice', [App\Http\Controllers\FrontController::class, 'registration_invoice'])->name('registration_invoice');
    Route::post('/marathon-registration', [App\Http\Controllers\FrontController::class, 'marathon_registration'])->name('marathon_registration');
    Route::get('/awards', [App\Http\Controllers\FrontController::class, 'awards'])->name('awards');
    Route::get('/awards/category/{id}', [App\Http\Controllers\FrontController::class, 'awards_criteria'])->name('awards_criteria');
    Route::get('/votes', [App\Http\Controllers\FrontController::class, 'votes'])->name('votes');
    Route::get('/votes/{id}', [App\Http\Controllers\FrontController::class, 'votes_nominees'])->name('votes_nominees');
    // Route::get('/awards-vote', [App\Http\Controllers\FrontController::class, 'awards_vote'])->name('awards_vote');
    Route::get('/profile', [App\Http\Controllers\FrontController::class, 'profile'])->name('profile');
    Route::get('/contact-us', [App\Http\Controllers\FrontController::class, 'contact_us'])->name('contact_us');
    Route::get('/refund-policy', [App\Http\Controllers\FrontController::class,'refund_policy'])->name('refund_policy');
    Route::post('/subscribe', [App\Http\Controllers\FrontController::class, 'subscribe'])->name('subscribe');

    Route::post('/contact-us', [App\Http\Controllers\FrontController::class,'contact_us_store'])->name('contact_us_store');
    Route::post('/package_payment',[App\Http\Controllers\FrontController::class,'package_payment'])->name('package_payment');
    Route::get('/awards/nominees', [App\Http\Controllers\FrontController::class,'awards_nominees'])->name('awards_nominees');
    Route::post('/awards/nominees', [App\Http\Controllers\FrontController::class,'awards_nominees_store'])->name('awards_nominees_store');
    Route::post('/awards-vote', [App\Http\Controllers\FrontController::class,'awards_vote_store'])->name('awards_vote_store');
    Route::get('/gallery/2021-event', [App\Http\Controllers\FrontController::class,'gallery_2021'])->name('gallery_2021');
Route::group(['namespace' => 'Admin', 'prefix' => 'admin','as'=>'admin.'], function() {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
    Route::get('/profile', [App\Http\Controllers\Admin\DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\Auth\ProfileController::class, 'profile_update'])->name('profile_update');
    Route::get('/gallery', [App\Http\Controllers\Admin\DashboardController::class, 'gallery'])->name('gallery');
    Route::get('/gallery/index', [App\Http\Controllers\Admin\DashboardController::class, 'gallery_index']);
    Route::post('/gallery/add', [App\Http\Controllers\Admin\DashboardController::class, 'gallery_add'])->name('gallery.add');
    Route::post('/gallery/store', [App\Http\Controllers\Admin\DashboardController::class, 'gallery_store'])->name('gallery.store');
    Route::get('/gallery/{id}/edit', [App\Http\Controllers\Admin\DashboardController::class, 'gallery_edit'])->name('gallery.edit');
    Route::get('/gallery/{id}/delete', [App\Http\Controllers\Admin\DashboardController::class, 'gallery_delete'])->name('gallery.delete');
    Route::delete('/gallery/delete-all', [App\Http\Controllers\Admin\DashboardController::class, 'gallery_delete_all'])->name('gallery.delete_all');
    Route::get('/subscribers', [App\Http\Controllers\Admin\DashboardController::class, 'subscribers'])->name('subscribers');
    Route::get('/subscribers/{id}/delete', [App\Http\Controllers\Admin\DashboardController::class, 'subscribers_delete'])->name('subscribers.delete');
    Route::delete('/subscribers/delete-all', [App\Http\Controllers\Admin\DashboardController::class, 'subscribers_delete_all'])->name('subscribers.delete_all');
   
    Route::get('/contact-us', [App\Http\Controllers\Admin\DashboardController::class, 'contact_us'])->name('contact_us');
    Route::get('/contact-us/{id}/view', [App\Http\Controllers\Admin\DashboardController::class, 'contact_us_view'])->name('contact_us.view');
    Route::post('/contact-us/update', [App\Http\Controllers\Admin\DashboardController::class, 'contact_us_update'])->name('contact_us.update');
    Route::get('/contact-us/{id}/delete', [App\Http\Controllers\Admin\DashboardController::class, 'contact_us_delete'])->name('contact_us.delete');
    Route::delete('/contact-us/delete-all', [App\Http\Controllers\Admin\DashboardController::class, 'contact_us_delete_all'])->name('contact_us.delete_all');
    Route::get('/contact-us/{id}/delete', [App\Http\Controllers\Admin\DashboardController::class, 'contact_us_delete'])->name('contact_us.delete');
    Route::delete('/contact-us/delete-all', [App\Http\Controllers\Admin\DashboardController::class, 'contact_us_delete_all'])->name('contact_us.delete_all');
   
    Route::get('/marathon/runners', [App\Http\Controllers\Admin\DashboardController::class, 'marathon_runners'])->name('marathon_runners');
    Route::post('/marathon/runners/add', [App\Http\Controllers\Admin\DashboardController::class, 'marathon_runners_add'])->name('marathon_runners.add');
    Route::post('/marathon/runners/store', [App\Http\Controllers\Admin\DashboardController::class, 'marathon_runners_store'])->name('marathon_runners.store');
    Route::get('/marathon/runners/{id}/edit', [App\Http\Controllers\Admin\DashboardController::class, 'marathon_runners_edit'])->name('marathon_runners.edit');
    Route::get('/marathon/runners/{id}/delete', [App\Http\Controllers\Admin\DashboardController::class, 'marathon_runners_delete'])->name('marathon_runners.delete');
    Route::delete('/marathon/runners/delete-all', [App\Http\Controllers\Admin\DashboardController::class, 'marathon_runners_delete_all'])->name('marathon_runners.delete_all');
    Route::get('/marathon/settings', [App\Http\Controllers\Admin\DashboardController::class, 'marathon_settings'])->name('marathon_settings');
    Route::post('/marathon/settings/store', [App\Http\Controllers\Admin\DashboardController::class, 'marathon_settings_store'])->name('marathon_settings_store');
    
    Route::get('/awards/category', [App\Http\Controllers\Admin\DashboardController::class, 'award_category'])->name('award_category');
    Route::get('/awards/category/index', [App\Http\Controllers\Admin\DashboardController::class, 'award_category_index'])->name('award_category_index');
    Route::get('/awards/category/add', [App\Http\Controllers\Admin\DashboardController::class, 'award_category_add_index'])->name('award_category_add_index');
    Route::post('/awards/category/add', [App\Http\Controllers\Admin\DashboardController::class, 'award_category_add'])->name('award_category_add');
    Route::post('/awards/category/store', [App\Http\Controllers\Admin\DashboardController::class, 'award_category_store'])->name('award_category_store');
    Route::get('/awards/category/{id}/edit', [App\Http\Controllers\Admin\DashboardController::class, 'award_category_edit'])->name('award_category_edit');
    Route::get('/awards/category/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'award_category_destroy'])->name('award_category_destroy');
    Route::delete('/awards/category/delete-all', [App\Http\Controllers\Admin\DashboardController::class, 'award_category_destroy_all'])->name('award_category_destroy_all');
    Route::get('/awards/nominee', [App\Http\Controllers\Admin\DashboardController::class, 'award_nominee'])->name('award_nominee');
    Route::get('/awards/nominee/{id}/edit', [App\Http\Controllers\Admin\DashboardController::class, 'award_nominee_edit'])->name('award_nominee_edit');
    Route::post('/awards/nominee', [App\Http\Controllers\Admin\DashboardController::class, 'award_nominee_store'])->name('award_nominee_store');
    Route::post('/awards/nominee/store', [App\Http\Controllers\Admin\DashboardController::class,'awards_nominees_store'])->name('awards_nominees_store');
    Route::delete('/awards/nominee/delete-all', [App\Http\Controllers\Admin\DashboardController::class,'awards_nominees_delete'])->name('awards_nominees_delete');
    Route::get('/awards/settings', [App\Http\Controllers\Admin\DashboardController::class, 'award_settings'])->name('award_settings');
    Route::post('/awards/settings/store', [App\Http\Controllers\Admin\DashboardController::class, 'award_settings_store'])->name('award_settings_store');
    
   //Users Route
    Route::get('/account/user', [App\Http\Controllers\Admin\UsersController::class, 'users_index'])->name('users_index');
    Route::get('/account/roles-permissions', [App\Http\Controllers\Admin\UsersController::class, 'roles_permissions'])->name('roles_permissions');
    Route::get('/account/users', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('user_index');
    Route::post('/account/users', [App\Http\Controllers\Admin\UsersController::class, 'store'])->name('user_store');
    Route::get('/account/users/{id}/edit', [App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('user_edit');
    Route::delete('/account/users/{id}', [App\Http\Controllers\Admin\UsersController::class, 'destroy'])->name('user_destroy');
    Route::delete('/account/users-delete-all', [App\Http\Controllers\Admin\UsersController::class, 'destroy_all'])->name('user_destroy_all');
    //Roles route
    Route::get('/account/roles', [App\Http\Controllers\Admin\RolesController::class, 'roleindex'])->name('roleindex');
    Route::get('/account/role', [App\Http\Controllers\Admin\RolesController::class, 'index'])->name('role_index');
    Route::post('/account/role', [App\Http\Controllers\Admin\RolesController::class, 'store'])->name('role_store');
    Route::get('/account/role/{id}/edit', [App\Http\Controllers\Admin\RolesController::class, 'edit'])->name('role_edit');
    Route::delete('/account/role/{id}', [App\Http\Controllers\Admin\RolesController::class, 'destroy'])->name('role_destroy');
    Route::delete('/account/role-delete-all', [App\Http\Controllers\Admin\RolesController::class, 'destroy_all'])->name('role_destroy_all');
    //Permisiions Route
    Route::get('/account/permission', [App\Http\Controllers\Admin\PermisionsController::class, 'permissionindex'])->name('permissionindex');
    Route::get('/account/permissions', [App\Http\Controllers\Admin\PermisionsController::class, 'index'])->name('permission_index');
    Route::post('/account/permissions', [App\Http\Controllers\Admin\PermisionsController::class, 'store'])->name('permission_store');
    Route::get('/account/permissions/{id}/edit', [App\Http\Controllers\Admin\PermisionsController::class, 'edit'])->name('permission_edit');
    Route::delete('/account/permissions/{id}', [App\Http\Controllers\Admin\PermisionsController::class, 'destroy'])->name('permission_destroy');
    Route::delete('/account/permissions-delete-all', [App\Http\Controllers\Admin\PermisionsController::class, 'destroy_all'])->name('permission_destroy_all');
    //Messages Route
    Route::get('/messages', [App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/star/{tag:slug}', [App\Http\Controllers\Admin\MessageController::class, 'star'])->name('messages.star');
    Route::get('/messages/unstar/{tag:slug}', [App\Http\Controllers\Admin\MessageController::class, 'unstar'])->name('messages.unstar');
    Route::get('/messages/sent', [App\Http\Controllers\Admin\MessageController::class, 'sent_messages'])->name('messages.sent_messages');
    Route::get('/messages/sent/{tag:slug}', [App\Http\Controllers\Admin\MessageController::class, 'read_sent_messages'])->name('messages.read_sent_messages');
    Route::delete('/messages/sent/destroy', [App\Http\Controllers\Admin\MessageController::class, 'destroy_all_sent_message'])->name('messages.destroy_all_sent_message');
    Route::get('/messages/trash',  [App\Http\Controllers\Admin\MessageController::class, 'trash_messages'])->name('messages.trash_messages');
    Route::get('/messages/trash/{tag:slug}', [App\Http\Controllers\Admin\MessageController::class, 'read_trash_messages'])->name('messages.read_trash_messages');
    Route::get('/messages/trash/{tag:slug}/restore',  [App\Http\Controllers\Admin\MessageController::class, 'restore_destroyed_message'])->name('messages.restore_destroyed_message');
    Route::delete('/messages/trash/restore',  [App\Http\Controllers\Admin\MessageController::class, 'restore_all_destroyed_message'])->name('messages.restore_all_destroyed_message');
    Route::get('/messages/trash/{tag:slug}/destroy-permanently',  [App\Http\Controllers\Admin\MessageController::class, 'destroy_message_permanently'])->name('messages.destroy_message_permanently');
    Route::delete('/messages/trash/destroy-permanently',  [App\Http\Controllers\Admin\MessageController::class, 'destroy_all_message_permanently'])->name('messages.destroy_all_message_permanently');
    Route::get('/messages/new-message',  [App\Http\Controllers\Admin\MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages/store',  [App\Http\Controllers\Admin\MessageController::class, 'store'])->name('messages.store');
    Route::post('/messages/{tag:slug}/reply',  [App\Http\Controllers\Admin\MessageController::class, 'reply'])->name('messages.reply');
    Route::get('/messages/{tag:slug}',  [App\Http\Controllers\Admin\MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{tag:slug}/destroy',  [App\Http\Controllers\Admin\MessageController::class, 'destroy'])->name('messages.destroy');
    Route::delete('/messages/destroy-all',  [App\Http\Controllers\Admin\MessageController::class, 'destroy_all'])->name('messages.destroy_all');
    //Mail Route
    Route::get('/mails', [App\Http\Controllers\Admin\MailController::class, 'index'])->name('mails.index');
    Route::get('/mails/compose', [App\Http\Controllers\Admin\MailController::class, 'create'])->name('mails.create');
    Route::get('/mails/mailshot/compose', [App\Http\Controllers\Admin\MailController::class, 'mailshot'])->name('mails.mailshot.create');
    Route::post('/mails', [App\Http\Controllers\Admin\MailController::class, 'store'])->name('mails.store');
    Route::post('/mails/mailshot', [App\Http\Controllers\Admin\MailController::class, 'storeMailshot'])->name('mails.mailshot.store');
  
    //Site Setting Route
    Route::get('/settings/site-settings', [App\Http\Controllers\Admin\DashboardController::class, 'site_settings_index'])->name('site_settings_index');
    Route::post('/settings/site-settings', [App\Http\Controllers\Admin\DashboardController::class, 'site_settings_store'])->name('site_settings_store');
    Route::get('/settings/site-settings/{id}/edit', [App\Http\Controllers\Admin\DashboardController::class, 'site_settings_edit'])->name('site_settings_edit');
    Route::delete('/settings/site-settings/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'site_settings_destroy'])->name('site_settings_destroy');
    //Payment Setting Route
    Route::get('/settings/payments', [App\Http\Controllers\Admin\DashboardController::class, 'payments_settings_index'])->name('payments_settings.index');
    Route::post('/settings/payments', [App\Http\Controllers\Admin\DashboardController::class, 'payments_settings_store'])->name('payments_settings.store');
    Route::get('/settings/payments/{tag:slug}/edit', [App\Http\Controllers\Admin\DashboardController::class, 'payments_settings_edit'])->name('payments_settings.edit');
    Route::delete('/settings/payments/{tag:slug}', [App\Http\Controllers\Admin\DashboardController::class, 'payments_settings_destroy'])->name('payments_settings.destroy');
    //Dpo Group Payment Route
    Route::get('/payments/dpo', [App\Http\Controllers\Admin\DashboardController::class, 'dpo_payments_index'])->name('dpo_payments.index');
    Route::get('/payments/dpo/{id}/view', [App\Http\Controllers\Admin\DashboardController::class, 'dpo_payments_index_show'])->name('dpo_payments.show');
    Route::get('/payments/dpo/view', [App\Http\Controllers\Admin\DashboardController::class, 'dpo_payments_index_view'])->name('dpo_payments.view');
    Route::post('/payments/dpo/verify', [App\Http\Controllers\Admin\DashboardController::class, 'dpo_payments_verify'])->name('dpo_payments.verify');
});
