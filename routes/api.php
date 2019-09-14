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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('volunteers', 'Api\VolunteerController');
Route::apiResource('geolocation', 'Api\GeolocationController');
Route::apiResource('organisation', 'Api\OrganisationController');
Route::apiResource('rating', 'Api\RatingController');
Route::get('volunteer/visit/{user}', 'Api\VolunteerController@visitCounter')->name('volunteer.visit');
Route::get('geolocation/calc/{lat}/{long}', 'Api\GeolocationController@calculate')->name('geolocation.calculate');
;
