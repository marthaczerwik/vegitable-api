<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    
    /**
      * To retrieve all devices belonging to user
      */
    public function getDevices($id){

        $devices = Device::where('userId_fk', $id)->get();

        return response()->json($devices);
        
    }

    /**
     * Update device when user first connects device (add user id FK)
     */ 
  public function updateDevice(Request $request){
        
        $deviceId = $request->device;
        $userId = $request->user;

        $device = Device::find($deviceId);

        $device->userId_fk = $userId;
        $device->lastUpdateDateTime = now()->toDateTimeString();
        $device->archiveDateTime = NULL;
        $device->save();

        return response()->json($device);
        
    }
    

    /**
     * To archive a device
     */
    public function deleteDevice($id){        

        $device = Device::find($id);

        $device->userId_fk = NULL;
        $device->lastUpdateDateTime = now()->toDateTimeString();
        $device->archiveDateTime = now()->toDateTimeString();
        $device->save();

        return response()->json($device);

    }
}
