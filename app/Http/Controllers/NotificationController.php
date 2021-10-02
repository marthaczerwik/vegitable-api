<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * For creating a new row in notification table once user account created with default values
     * TODO: change return to custom object with HTTP status code and message and notification setting id
     * TODO: error handling if cannot be saved to db
     */
    public function createSettings(Request $request){
        //create new notification object
        $settings = new Notification();

        //assign default values and attach user's id as foreign key
        $settings->dailyNotification = 1;
        $settings->dailyNotificationTime = '08:00:00';
        $settings->alertNotification = 1;
        $settings->deviceNotification = 1;
        $settings->userId_fk = $request->input('userId_fk');
        
        //insert to db
        $settings->save();

        return response()->json($settings);
    }
    
    
    /**
     * Return user's notiication settings
     * TODO: confirm if need to change return to custom object with HTTP status code, message, and notification object within that object
     */
    public function getSettings($id){
        return Notification::find($id);
    }

    /**
     * Update fields when user edits their settings
     * TODO: change return to custom object with HTTP status code and message and notification setting id
     * TODO: error handling if cannot be saved to db
     */ 
    public function updateSettings(Request $request, $id){
        //find settings
        $settings = Notification::find($id);
        
        //update based on request input
        $settings->dailyNotification = $request->input('dailyNotification');
        $settings->dailyNotificationTime = $request->input('dailyNotificationTime');
        $settings->alertNotification = $request->input('alertNotification');
        $settings->deviceNotification = $request->input('deviceNotification');
       
        //update record in db
        $settings->save();

        return response()->json($settings);
    }

    /**
     * TODO: method to GET all notifications from log - may need to be its own Model/Controller
     */
}
  