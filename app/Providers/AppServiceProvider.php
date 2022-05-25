<?php

namespace App\Providers;

use App\Models\Profile;
use App\Models\Payment\Dpo;
use App\Models\AwardNominee;
use App\Models\AwardCategory;
use App\Models\GeneralSetting;
use App\Models\Payment\DpoGroup;
use App\Models\AwardMarathonSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\Message\Thread as MessageThread;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Paginator::useBootstrap();
        $general_settings = GeneralSetting::get()->first();
        if ($general_settings !== null) {
            $site_name = $general_settings->site_name;
            $site_url = $general_settings->site_url;
            $site_logo = $general_settings->site_logo;
            $site_icon = $general_settings->site_icon;
            Config::set('app.name', $site_name);
            Config::set('app.url', $site_url);
            Config::set('app.logo', $site_logo);
            Config::set('app.icon', $site_icon);
        }



        view()->composer(['admin.layout.app', 'admin.layout.aside', 'admin.messages.*'], function ($view) {
            $unread_messages = MessageThread::forUserWithNewMessages(Auth::id())->latest('updated_at')->paginate(3);
            $general_settings = GeneralSetting::get()->first();
            $profile = Profile::where('user_id', auth()->user()->id)->first();
            $unread_message = MessageThread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();



            $view->with(['profile' => $profile, 'general_settings' => $general_settings, 'unread_message' => $unread_message, 'unread_messages' => $unread_messages]);
        });

        view()->composer(['*'], function ($view) {
            $award_settings = AwardMarathonSetting::get()->first();
            $view->with(['award_settings' => $award_settings]);
        });
        view()->composer(['layouts.*'], function ($view) {

            $award_category = AwardCategory::nominees()->latest()->get();

            $view->with(['award_category' => $award_category]);
        });

        view()->composer(['partials.*'], function ($view) {

            $award_category = AwardCategory::nominees()->latest()->get();
            $dpo = new Dpo();
            $payment_options = $dpo->companyMobilePaymentOptions();
            $data = $payment_options['result'];

            $view->with(['award_category' => $award_category, 'payment_options' => $data]);
        });
    }
}
