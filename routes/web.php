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
    return view('overview')->with([
        'pageTitle' => 'Přehled systému',
    ]);
})->name('overview')->middleware('auth');

// Routes for authentication
Route::get('prihlasit', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('prihlasit', 'Auth\LoginController@login');
Route::post('odhlasit', 'Auth\LoginController@logout')->name('auth.logout');

Route::get('registrovat', 'Auth\RegisterController@showRegistrationForm')->name('employees.create');
Route::post('registrovat', 'Auth\RegisterController@register')->name('employees.store');

$controllerRoutes = [
    'department' => 'ustavy',
    'device' => 'zarizeni',
    'employee' => 'zamestnanci',
    'repair' => 'opravy',
    'room' => 'mistnosti'
];

// Routes for other controllers specified above
foreach ($controllerRoutes as $controllerName => $translatedName) {
    Route::post($translatedName, ucfirst($controllerName) . 'Controller@store')->name(str_plural($controllerName) . '.store');
    Route::get($translatedName, ucfirst($controllerName) . 'Controller@index')->name(str_plural($controllerName) . '.index');
    Route::get($translatedName . '/pridat', ucfirst($controllerName) . 'Controller@create')->name(str_plural($controllerName) . '.create');
    Route::delete($translatedName . '/{' . $controllerName . '}', ucfirst($controllerName) . 'Controller@destroy')->name(str_plural($controllerName) . '.destroy');
    Route::get($translatedName  . '/{' . $controllerName . '}', ucfirst($controllerName) . 'Controller@show')->name(str_plural($controllerName) . '.show');
    Route::put($translatedName  . '/{' . $controllerName . '}', ucfirst($controllerName) . 'Controller@update')->name(str_plural($controllerName) . '.update');
    Route::get($translatedName  . '/{' . $controllerName . '}/upravit', ucfirst($controllerName) . 'Controller@edit')->name(str_plural($controllerName) . '.edit');
};
