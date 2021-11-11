<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    
    /**
      * To retrieve all devices belonging to user
      */
    public function getDevices($userId){
        //find all deviceslinked to the user
        $devices = Device::where('userId_fk', $userId)->get();

        return response()->json($devices);
        
    }

    /**
     * To retrieve single device that the user owns
     */
    public function getDevice($userId, $deviceId){
        return Device::where('userId_fk', $userId)
        ->where('localId', $deviceId)
        ->get();
    }

    /**
     * To retrieve single device, to check if it exists before pairing
     */
    public function checkForDevice($deviceId){
        return Device::find($deviceId);
    }

    /**
     * Update device when user first connects device (add user id FK)
     * TODO: error handling if cannot be saved to db, if device doesn't exist
     * TODO: determine if this sets values here or if it takesvalues from local db (if latter, change dates and add localid)
     */ 
    public function initializeDevice(Request $request){
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
     * To archive or update a device
     * TODO: error handling if cannot be saved to db, if device id doesn't exist (optional)
     * TODO: determine if the update and archive time is set here or taken from local db
     */
    public function updateDevice(Request $request, $userId, $deviceId){        

        //find device
        $device = Device::where('userId_fk', $userId)
        ->where('deviceId', $deviceId)
        ->first();

        if ($request->archive == 'true'){
            //remove foreign key (user no longer attached to this device)
            $device->userId_fk = 0;
            $device->lastUpdateDateTime = $request->input('lastUpdateDateTime');
            $device->archiveDateTime = $request->input('archiveDateTime');
        } else {
            $device->deviceName = $request->input('deviceName');
            $device->lastUpdateDateTime = $request->input('lastUpdateDateTime');
        }

        //save updated device
        $device->save();

        //return device
        return response()->json($device);

    }
}
