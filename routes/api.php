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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
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
        Route::post('register', 'AuthController@register');
        // Route::post('forgot', 'Auth\ForgotPasswordController')->name('forgot.password');
        Route::post('forgot', 'AuthController@forgotPassword');
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::delete('logout', 'AuthController@logout');
            Route::get('profile', 'AuthController@profile');
            Route::get('photo', 'AuthController@photo');
            Route::get('checkin', 'AuthController@checkin');
            Route::get('permissions', 'AuthController@permissions');
            Route::put('password', 'AuthController@changePassword');
            Route::put('profile', 'AuthController@updateProfile');
            Route::post('fcm', 'AuthController@createUpdateFCM');
        });
    });

    Route::get("roles/{id}/permissions", 'Api\RolesResourcesController@getPermissions')->where('id', '[a-zA-Z0-9]+');
    Route::put("roles/{id}/permissions", 'Api\RolesResourcesController@updatePermissions')->where('id', '[a-zA-Z0-9]+');

    Route::get("users/{id}", 'Api\UsersResourcesController@show')->where('id', '[a-zA-Z0-9]+');
    Route::get("users/{id}/roles", 'Api\UsersResourcesController@getRoles')->where('id', '[a-zA-Z0-9]+');
    Route::put("users/{id}/roles", 'Api\UsersResourcesController@updateRoles')->where('id', '[a-zA-Z0-9]+');
    Route::put("users/{id}/password", 'Api\UsersResourcesController@updatePassword')->where('id', '[a-zA-Z0-9]+'); // patch collection by ID
    Route::post("users/{id}/photo", 'Api\UsersResourcesController@updatePhoto')->where('id', '[a-zA-Z0-9]+');

    Route::post("files/upcreate", 'Api\FilesResourcesController@upCreate');

    Route::post("notifications", 'Api\NotificationsResourcesController@store');

    // NOTIFICATIONS
    Route::get("notifications/{id}", 'Api\NotificationsResourcesController@show'); // get collection by ID
    Route::put("notifications/{id}/mark-as-read", 'Api\NotificationsResourcesController@markAsRead'); // get collection by ID
    Route::put("notifications/{id}/mark-as-unread", 'Api\NotificationsResourcesController@markAsUnread'); // get collection by ID
    Route::put("notifications/mark-all-read", 'Api\NotificationsResourcesController@markAllRead'); // get collection by ID

    Route::get('/sysparams/groups', 'Api\SysparamsResourcesController@getGroupNames');

});
