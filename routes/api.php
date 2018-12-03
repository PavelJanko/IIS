<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$controllerRoutes = [
    'department' => 'ustavy',
    'device' => 'zarizeni',
    'employee' => 'zamestnanci',
    'repair' => 'opravy',
    'room' => 'mistnosti'
];

foreach ($controllerRoutes as $controllerName => $translatedName)
    Route::get($translatedName . '/graf', ucfirst($controllerName) . 'Controller@getGraphData')->name(str_plural($controllerName) . '.graph');
