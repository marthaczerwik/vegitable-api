<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\BucketController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\NotificationController;
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
 * 5.) delete user - TODO: find way to get PATCH working and change method to PATCH
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
 * 3.) delete device - TODO: find way to get PATCH working and change method to PATCH
 */

Route::get('/devices/{id}', [DeviceController::class, 'getDevices']); 
Route::put('/device', [DeviceController::class, 'updateDevice']);
Route::put('/device/{id}', [DeviceController::class, 'deleteDevice']);


/**
  * Router methods for calls related to Bucket - review route naming
  * 1.) get all buckets belonging to user (greenhouse page)
  * 2.) get bucket by id (view bucket page)
  * 3.) create bucket (add new bucket) (POST)
  * 4.) update bucket
  * 5.) delete/archive bucket - TODO: find way to get PATCH working and change method to PATCH
  */

Route::get('/user/{id}/buckets', [BucketController::class, 'getBuckets']); 
Route::get('/bucket/{id}', [BucketController::class, 'getBucket']);
Route::post('/bucket', [BucketController::class, 'createBucket']); 
Route::put('/bucket/{id}', [BucketController::class, 'updateBucket']); 
//Route::put('/bucket/{id}', [BucketController::class, 'deleteBucket']);

  /**
   * Router methods for calls related to Plant - review route naming
   * 1.) get single plant (view plant)
   * 2.) get all plants of a bucket
   * 3.) update plant
   * 4.) create plant
   * 5.) delete/archive plant - TODO: find way to get PATCH working and change method to PATCH
   * TODO: add plant type (POST)
   * TODO: API call to trefle.io to get plant types to populate dropdown (add plant) (GET)
   * TODO: get plant types (get any user-inputted plant types to also populate dropdown on add plant)
   * TODO: copy archived plant (POST)
   */
Route::get('/plant/{id}', [PlantController::class, 'getPlant']); 
Route::get('/bucket/{id}/plants', [PlantController::class, 'getPlants']); 
Route::put('/plant/{id}', [PlantController::class, 'updatePlant']);
Route::post('/plant', [PlantController::class, 'createPlant']);
//Route::put('/plant/{id}', [PlantController::class, 'deletePlant']);
//Route::post('/plantType', [PlantController::class, 'createPlantType']);
//Route::get('/user/{id}/plantTypes', [PlantController::class, 'getPlantTypes']);

  /**
   * Router methods for calls related to device readings - review route naming
   * 1.) Get current device reading (view bucket data - current)
   * 2.) Send readings from ESP32 sensors
   * TODO - get bucket history historical (between start and end dates for particular device)
   * 
   */
Route::get('/deviceReading/{id}', [DeviceReadingController::class, 'getCurrentDeviceReading']);
Route::post('/deviceReading', [DeviceReadingController::class, 'createDeviceReading']);
//Route::get('/deviceReading/historical/{id}', [DeviceReadingController::class, 'getHistoricalData']);

  /**
   * Router methods for calls related to notification settings
   * 1.) Get notification settings for user
   * 2.) update notification settings
   * 3.) create notifications (when account created, default everything is on and time set to 8am)
   */
Route::get('/notification/{id}', [NotificationController::class, 'getSettings']); //works
Route::put('/notification/{id}', [NotificationController::class, 'updateSettings']);
Route::post('/notification', [NotificationController::class, 'createSettings']); 

/**
 * Changes TBD
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
