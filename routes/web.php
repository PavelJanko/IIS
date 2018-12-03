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
    return redirect()->route('devices.index');
});

// Routes for authentication
Route::get('prihlasit', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('prihlasit', 'Auth\LoginController@login');
Route::post('odhlasit', 'Auth\LoginController@logout')->name('auth.logout');

Route::get('zamestnanci/pridat', 'Auth\RegisterController@showRegistrationForm')->name('employees.create');
Route::post('zamestnanci', 'Auth\RegisterController@register')->name('employees.store');

$controllerRoutes = [
    'department' => 'ustavy',
    'device' => 'zarizeni',
    'employee' => 'zamestnanci',
    'repair' => 'opravy',
    'room' => 'mistnosti'
];

// Routes for other controllers specified above
foreach ($controllerRoutes as $controllerName => $translatedName) {
    if ($controllerName != 'employee') {
        Route::post($translatedName, ucfirst($controllerName) . 'Controller@store')->name(str_plural($controllerName) . '.store');
        Route::get($translatedName . '/pridat', ucfirst($controllerName) . 'Controller@create')->name(str_plural($controllerName) . '.create');
    }

    if ($controllerName != 'repair') {
        Route::put($translatedName  . '/{' . $controllerName . '}', ucfirst($controllerName) . 'Controller@update')->name(str_plural($controllerName) . '.update');
        Route::get($translatedName  . '/{' . $controllerName . '}/upravit', ucfirst($controllerName) . 'Controller@edit')->name(str_plural($controllerName) . '.edit');
    }

    if ($controllerName == 'room' || $controllerName == 'department')
        Route::get($translatedName  . '/{' . $controllerName . '}', ucfirst($controllerName) . 'Controller@show')->name(str_plural($controllerName) . '.show');

    Route::get($translatedName, ucfirst($controllerName) . 'Controller@index')->name(str_plural($controllerName) . '.index');
    Route::delete($translatedName . '/{' . $controllerName . '}', ucfirst($controllerName) . 'Controller@destroy')->name(str_plural($controllerName) . '.destroy');
};

Route::get('opravy/{device}/zazadat', 'RepairController@claim')->name('repairs.claim');
Route::get('opravy/{repair}/rozpracovat', 'RepairController@proceed')->name('repairs.proceed');
Route::get('opravy/{repair}/dokoncit', 'RepairController@finish')->name('repairs.finish');
