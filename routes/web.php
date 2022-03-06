<?php

use App\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\fileExists;

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
    return redirect()->route("home");
});

Auth::routes();

Route::get('/home', 'HomeController')->name('home');

Route::name('budgets.')->prefix('budget')->group(function () {
    Route::get('/add', 'BudgetController@add')->name('create');
    Route::post('/add', 'BudgetController@save')->name('store');
    Route::post('/delete', 'BudgetController@delete')->name('destroy');
});

Route::name('categories.')->prefix('categories')->group(function () {
    Route::get('/', 'CategoryController@index')->name('index');
    Route::get('/add', 'CategoryController@create')->name('create');
    Route::post('/add', 'CategoryController@store')->name('store');
    Route::post('/delete', 'CategoryController@destroy')->name('destroy');
});

Route::prefix('profile')->group(function () {
    Route::get('/', 'ProfileController@index')->name('profile');
    Route::post('/upload', 'ProfileController@upload')->name('profile-upload');
});

Route::get("statistics/{year?}", 'StatisticsController@index')->name('statistics')->where('year', '[0-9]+');

Route::name("icons.")->prefix('icons')->group(function () {
    Route::get('/', 'IconController@index')->name('index');
    Route::get('/add', 'IconController@create')->name('create');
    Route::post('/add', 'IconController@store')->name('store');
    Route::get('/edit/{id}', 'IconController@edit')->name('edit');
    Route::post('/edit', 'IconController@update')->name('update');
    Route::post('/delete', 'IconController@destroy')->name('destroy');
});

Route::name("setting.")->prefix('setting')->group(function () {
    Route::get('/', 'SettingController@index')->name('index');
    Route::patch('/edit/language', 'SettingController@updateLanguage')->name('update.lanuage');
    Route::patch('/edit/unit', 'SettingController@updateUnit')->name('update.unit');
});