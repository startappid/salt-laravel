<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::namespace('App\Http\Controllers')->middleware(['api'])->prefix('v1')->group(function () {

    Route::middleware(['auth:api'])->prefix('role_has_permission')->group(function () {
        Route::post('{id}/revoke_permission', 'Api\ApiRoleAndPermissionController@revokePermission');
        Route::post('{id}/give_permission', 'Api\ApiRoleAndPermissionController@givePermision');
    });

    Route::middleware(['auth:api'])->prefix('user_has_role')->group(function () {
        Route::post('{id}/assign_role', 'Api\ApiRoleAndPermissionController@assignRole');
        Route::post('{id}/remove_role', 'Api\ApiRoleAndPermissionController@removeRole');
    });

    Route::group([
        'prefix' => 'user'
    ], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@signup');
        Route::post('forgot', 'AuthController@forgotPassword');
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::delete('logout', 'AuthController@logout');
            Route::get('profile', 'AuthController@profile');
            Route::get('checkin', 'AuthController@checkin');
            Route::patch('password', 'AuthController@changePassword');
            Route::post('fcm', 'AuthController@createUpdateFCM');
        });
    });

    Route::get("roles/{id}/permissions", 'Api\RolesResourcesController@getPermissions')->where('id', '[a-zA-Z0-9]+');
    Route::put("roles/{id}/permissions", 'Api\RolesResourcesController@updatePermissions')->where('id', '[a-zA-Z0-9]+');

    Route::get("users/{id}/roles", 'Api\UsersResourcesController@getRoles')->where('id', '[a-zA-Z0-9]+');
    Route::put("users/{id}/roles", 'Api\UsersResourcesController@updateRoles')->where('id', '[a-zA-Z0-9]+');
    Route::put("users/{id}/password", 'Api\UsersResourcesController@updatePassword')->where('id', '[a-zA-Z0-9]+'); // patch collection by ID

    // DEFAULT: API RESOURCES
    Route::get("{collection}", 'Api\ApiResourcesController@index'); // get entire collection
    Route::post("{collection}", 'Api\ApiResourcesController@store'); // create new collection

    Route::get("{collection}/trash", 'Api\ApiResourcesController@trash'); // trash of collection

    Route::post("{collection}/import", 'Api\ApiResourcesController@import'); // import collection from external
    Route::post("{collection}/export", 'Api\ApiResourcesController@export'); // export entire collection
    Route::get("{collection}/report", 'Api\ApiResourcesController@report'); // report collection

    Route::get("{collection}/{id}/trashed", 'Api\ApiResourcesController@trashed')->where('id', '[a-zA-Z0-9]+'); // get collection by ID from trash

    // RESTORE data by ID (id), selected IDs (selected), and All data (all)
    Route::post("{collection}/{id}/restore", 'Api\ApiResourcesController@restore')->where('id', '[a-zA-Z0-9]+'); // restore collection by ID

    // DELETE data by ID (id), selected IDs (selected), and All data (all)
    Route::delete("{collection}/{id}/delete", 'Api\ApiResourcesController@delete')->where('id', '[a-zA-Z0-9]+'); // hard delete collection by ID

    Route::get("{collection}/{id}", 'Api\ApiResourcesController@show')->where('id', '[a-zA-Z0-9]+'); // get collection by ID
    Route::put("{collection}/{id}", 'Api\ApiResourcesController@update')->where('id', '[a-zA-Z0-9]+'); // update collection by ID
    Route::patch("{collection}/{id}", 'Api\ApiResourcesController@patch')->where('id', '[a-zA-Z0-9]+'); // patch collection by ID
    // DESTROY data by ID (id), selected IDs (selected), and All data (all)
    Route::delete("{collection}/{id}", 'Api\ApiResourcesController@destroy')->where('id', '[a-zA-Z0-9]+'); // soft delete a collection by ID

});
