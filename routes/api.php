<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;

/*
|--------------------------------------------------------------------------
| WEB & MOBILE FRONTEND ROUTES
|--------------------------------------------------------------------------
*/
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

/*
|--------------------------------------------------------------------------
| BACKEND ADMIN DASHBOARD ROUTES
|--------------------------------------------------------------------------
*/

// Route::get('version', function () {
//     return response()->json(['version' => config('app.version')]);
// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     Log::debug('User:' . serialize($request->user()));
//     return $request->user();
// });

Route::namespace('App\\Http\\Controllers\\API\V1')->group(function () {
    Route::apiResources([
        'user' => 'UserController',
        'permission' => 'PermissionController',
        'service' => 'ServiceController',
        'booking' => 'BookingController',
        'category' => 'CategoryController',
        'page' => 'PageController',
        'complaint' => 'ComplaintController',
        'faq' => 'FaqController',
        'gallery' => 'GalleryController',
        'payment' => 'PaymentController',
        'assignment' => 'AssignmentController',
        'package' => 'PackageController',
    ]);

    Route::get('profile', 'ProfileController@profile');
    Route::put('profile', 'ProfileController@updateProfile');
    Route::post('change-password', 'ProfileController@changePassword');
    Route::get('getCategories', 'CategoryController@getCategories');
    Route::get('getVendorsList', 'UserController@getVendorsList');
    Route::get('getServicesList', 'ServiceController@getServicesList');
    Route::get('getSelectedServices/{id}', 'UserController@getSelectedServices');
    Route::get('getSelectedPermissions/{id}', 'UserController@getSelectedPermissions');
    Route::get('getSelectedVendors/{id}', 'AssignmentController@getSelectedVendors');
});
