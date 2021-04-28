<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * For creating a new row in notification table once user account created with default values
     */
    public function createSettings(Request $request){
        $settings = new Notification();

        $settings->dailyNotification = 1;
        $settings->dailyNotificationTime = '08:00:00';
        $settings->alertNotification = 1;
        $settings->deviceNotification = 1;
        $settings->userId_fk = $request->input('userId_fk');
        
        $settings->save();

        return response()->json($settings);
    }
    
    
    //get notification settings of user
    public function getSettings($id){
        return Notification::find($id);
    }

    /**
     * Update fields when user edits their settings
     */ 
    public function updateSettings(Request $request, $id){
        $settings = Notification::find($id);
        
        $settings->dailyNotification = $request->input('dailyNotification');
        $settings->dailyNotificationTime = $request->input('dailyNotificationTime');
        $settings->alertNotification = $request->input('alertNotification');
        $settings->deviceNotification = $request->input('deviceNotification');
       
        
        $settings->save();

        return response()->json($settings);
    }
}
  