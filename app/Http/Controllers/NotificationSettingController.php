<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationSetting;

class NotificationSettingController extends Controller
{
    /**
     * For creating a new row in notification table once user account created with default values
     * TODO: error handling if cannot be saved to db
     */
    public function createSettings(Request $request){
        //create new notification object
        $settings = new NotificationSetting();

        //assign default values and attach user's id as foreign key
        $settings->localId = $request->input('notificationSettingId');
        $settings->dailyNotification = $request->input('dailyNotification');
        $settings->dailyNotificationTime = $request->input('dailyNotificationTime');
        $settings->alertNotification = $request->input('alertNotification');
        $settings->deviceNotification = $request->input('deviceNotification');
        $settings->createDateTime = $request-> input('createDateTime');
        $settings->lastUpdateDateTime = $request-> input('lastUpdateDateTime');
        $settings->archiveDateTime = $request->input('archiveDateTime');
        $settings->userId_fk = $request->input('userId_fk');
        
        //insert to db
        $settings->save();

        return response()->json($settings);
    }
    
    
    /**
     * Return user's notification settings
     */
    public function getSettings($userId){
        return NotificationSetting::where('userId_fk', $userId)->first();
    }

    /**
     * Update fields when user edits their settings
     * TODO: error handling if cannot be saved to db
     */ 
    public function updateSettings(Request $request, $userId){
        //find settings
        $settings = NotificationSetting::where('userId_fk', $userId)->first();
        
        //update based on request input
        //$settings->localId = $request->input('notificationSettingId');
        $settings->dailyNotification = $request->input('dailyNotification');
        $settings->dailyNotificationTime = $request->input('dailyNotificationTime');
        $settings->alertNotification = $request->input('alertNotification');
        $settings->deviceNotification = $request->input('deviceNotification');
        $settings->lastUpdateDateTime = $request-> input('lastUpdateDateTime');
       
        //update record in db
        $settings->save();

        return response()->json($settings);
    }

}
  