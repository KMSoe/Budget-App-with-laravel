<?php

namespace App\Providers;

use App\Category;
use App\Setting;
use App\User;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use phpDocumentor\Reflection\Types\Float_;
use Ramsey\Uuid\Type\Decimal;

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
        Blade::if('admin', function () {
            return auth()->user()->role->value === 2;
        });

        Blade::if('self', function (Model $model) {
            return auth()->user()->id === $model->user_id;
        });

        view()->share('title', '');

        view()->composer('partials.*', function ($view) {
            $view->with('current_locale', auth()->user()->setting->language);
            $view->with('locales', config('app.available_locales'));
            $view->with('current_unit', auth()->user()->setting->budget_unit);
            $view->with('units', config('app.available_units'));
            $view->with('locale', array_search(auth()->user()->setting->language, config('app.available_locales')));
            $view->with('unit', array_search(auth()->user()->setting->budget_unit, config('app.available_units')));
        });
    }
}
