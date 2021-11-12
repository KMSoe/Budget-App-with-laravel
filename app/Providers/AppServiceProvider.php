<?php

namespace App\Providers;

use App\Category;
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

        Blade::directive('format', function ($num) {
            // if(app()->getLocale() == 'mm'){
                // $en_nums = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                // $mm_nums = ["၀", "၁", "၂", "၃", "၄", "၅", "၆", "၇", "၈", "၉"];
                // $num = str_replace($en_nums, $mm_nums, $num);
            // }
            return "{{ number_format($num, 2, '.', ',') }} {{ __(auth()->user()->setting->budget_unit) }} ";
            
        });

        Blade::directive('locale', function ($str) {
            if(app()->getLocale() == 'mm'){
                $en_nums = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                $mm_nums = ["၀", "၁", "၂", "၃", "၄", "၅", "၆", "၇", "၈", "၉"];
                $str = str_replace($en_nums, $mm_nums, $str);
            }
            return "{{ $str }}";
            
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

        // Blade::component('alert', Breadcrumb::class);
    }
}
