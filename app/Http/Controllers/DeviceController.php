<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    
    /**
      * To retrieve all devices belonging to user
      * TODO: confirm if need to change return to custom object with HTTP status code, message, and device array within that object
      */
    public function getDevices($id){
        //find all deviceslinked to the user
        $devices = Device::where('userId_fk', $id)->get();

        return response()->json($devices);
        
    }

    /**
     * To retrieve single device
     */
    public function getDevice($id){
        return Device::find($id);
    }

    /**
     * Update device when user first connects device (add user id FK)
     * TODO: validation (optional if front end handles this)
     * TODO: change return to custom object with HTTP status code and message and device id
     * TODO: error handling if cannot be saved to db, if device doesn't exist
     */ 
    public function updateDevice(Request $request){
        //find device in db
        $device = Device::find($request->device);

        //add user's id as the device's foreign key and ensure the archive is set to null (as it previously may have been archived)
        $device->userId_fk = $request->user;
        $device->lastUpdateDateTime = now()->toDateTimeString();
        $device->archiveDateTime = NULL;

        //save updated device
        $device->save();

        //return device
        return response()->json($device);
        
    }
    

    /**
     * To archive a device
     * TODO: change return to custom object with HTTP status code and message 
     * TODO: error handling if cannot be saved to db, if device id doesn't exist (optional)
     */
    public function deleteDevice($id){        

        //find device
        $device = Device::find($id);

        //remove foreign key (user no longr attached to this device)
        $device->userId_fk = NULL;
        $device->lastUpdateDateTime = now()->toDateTimeString();
        $device->archiveDateTime = now()->toDateTimeString();

        //save updated device
        $device->save();

        //return device
        return response()->json($device);

    }
}
