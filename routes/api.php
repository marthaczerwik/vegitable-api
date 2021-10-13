<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\BucketController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PlantTypeController;
use App\Http\Controllers\NotificationSettingController;
use App\Http\Controllers\NotificationLogController;
use App\Http\Controllers\DeviceReadingController;
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

/**
 * Router methods for calls related to User - need to review route naming
 * 1.) Get specific user via login parameters 
 * 2.) Get user via user id
 * 3.) Create user (POST)
 * 4.) update user (edit user profile)
 * 5.) delete user - TODO: find way to get PATCH working and change method to PATCH (if we don't have time, will need to just rename route)
 */

Route::get('/user/login', [UserController::class, 'logUserIn']); 
Route::get('/user/{id}', [UserController::class, 'getUser']); 
Route::post('/user', [UserController::class, 'createUser']); 
Route::put('/user/{id}', [UserController::class, 'updateUser']); 
//Route::put('/user/{id}', [UserController::class, 'deleteUser']);


/**
 * Router methods for calls related to device - review route naming
 * 1.) Get all devices that belong to user id (device mgmt page)
 * 2.) update device 
 * 3.) delete device - TODO: find way to get PATCH working and change method to PATCH (optional)
 */

Route::get('/devices/{userId}', [DeviceController::class, 'getDevices']); 
Route::put('/device', [DeviceController::class, 'initializeDevice']);
Route::put('/device/{deviceId}', [DeviceController::class, 'updateDevice']);
Route::get('/user/{userId}/device/{deviceId}', [DeviceController::class, 'getDevice']);


/**
  * Router methods for calls related to Bucket - review route naming
  * 1.) get all buckets belonging to user (greenhouse page)
  * 2.) get bucket by id (view bucket page)
  * 3.) create bucket (add new bucket) (POST)
  * 4.) update bucket
  * 5.) delete/archive bucket - TODO: find way to get PATCH working and change method to PATCH (if we don't have time, will need to just rename route)
  */

Route::get('/user/{userId}/buckets', [BucketController::class, 'getBuckets']); 
Route::get('/user/{userId}/bucket/{bucketId}', [BucketController::class, 'getBucket']);
Route::post('/bucket', [BucketController::class, 'createBucket']); 
Route::put('/user/{userId}/bucket/{bucketId}', [BucketController::class, 'updateBucket']); 
Route::put('/delete/user/{userId}/bucket/{bucketId}', [BucketController::class, 'deleteBucket']);

/**
 * Router methods for calls related to Plant
 * 1.) get single plant (view plant)
 * 2.) get all plants of a bucket
 * 3.) update plant
 * 4.) create plant
 * 5.) delete/archive plant - TODO: find way to get PATCH working and change method to PATCH (if we don't have time, will need to just rename route)
 */

Route::get('/user/{userId}/plant/{plantId}', [PlantController::class, 'getPlant']); 
Route::get('/user/{userId}/bucket/{bucketId}/plants', [PlantController::class, 'getPlants']); 
Route::put('/user/{userId}/plant/{plantId}', [PlantController::class, 'updatePlant']);
Route::post('/plant', [PlantController::class, 'createPlant']);
//Route::put('/plant/{id}', [PlantController::class, 'deletePlant']);
//Route::post('/plantType', [PlantController::class, 'createPlantType']);
//Route::get('/user/{id}/plantTypes', [PlantController::class, 'getPlantTypes']);

/**
 * Router methods for calls related to Plant Type - will need to create Model/Controller for plant type
 * 1.) create plant type 
 * 2.) get single plant type
 * 3.) get all plant types of a user
 */
Route::post('/plantType', [PlantTypeController::class, 'createPlantType']);
Route::get('user/{userId}/plantType/{plantTypeId}', [PlantTypeController::class, 'getPlantType']); 
Route::get('/user/{userId}', [PlantTypeController::class, 'getPlantTypes']); 


/**
 * Router methods for calls related to device readings - review route naming
 * 1.) Get current device reading (view bucket data - current)
 * 2.) Send readings from ESP32 sensors
 * TODO - get bucket history historical (between start and end dates for particular device)
 */

Route::get('/deviceReading/{id}', [DeviceReadingController::class, 'getCurrentDeviceReading']);
Route::post('/deviceReading', [DeviceReadingController::class, 'createDeviceReading']);
//Route::get('/deviceReading/historical/{id}', [DeviceReadingController::class, 'getHistoricalData']);

/**
 * Router methods for calls related to notification settings
 * 1.) Get notification settings for user
 * 2.) update notification settings
 * 3.) create notifications (when account created, default everything is on and time set to 8am)
 * TODO: get notification log (adding this table to the db so will need a GET for it)
 */
Route::get('/settings/{userId}', [NotificationSettingController::class, 'getSettings']); //works
Route::put('/settings/{userId}', [NotificationSettingController::class, 'updateSettings']);
Route::post('/settings', [NotificationSettingController::class, 'createSettings']); 

/**
 * Router methods for calls related to notification log
 * 1.) insert notification log
 * 2.) get all logs associated with a user's bucket
 */

Route::post('/log', [NotificationLogController::class, 'createLog']);
Route::get('/log/{userId}/{bucketId}', [NotificationLogController::class, 'getLogs']);


/**
 * Changes TBD - this is for authentication (who can access the API)
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
