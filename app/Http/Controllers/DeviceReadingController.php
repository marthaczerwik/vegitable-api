<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceReading;

class DeviceReadingController extends Controller
{
    //get most recent history row for bucket
    public function getCurrentDeviceReading($id){
        return DeviceReading::where('deviceId_fk', $id)->orderBy('deviceReadingId', 'desc')->first();

    }

    /*
    public function getHistoricalData($id, $startDate, $endDate, $sensorValue){
        return DeviceReading::where([
            ['bucketId_fk', $id],
            ['currentDateTime', '>=', $startDate],
            ['currentDateTime', '<=', $endDate],
            []
        ]);
    } */

        public function createDeviceReading(Request $request){
        $deviceReading = new DeviceReading();

        $deviceReading->currentDateTime = now()->toDateTimeString(); 
        $deviceReading->phValue = $request->input('phValue');
        $deviceReading->temperatureValue = $request->input('temperatureValue');
        $deviceReading->ppmValue = $request->input('ppmValue');
        $deviceReading->waterValue = $request->input('waterValue');
        $deviceReading->humidityValue = $request->input('humidityValue');
        $deviceReading->lightValue = $request->input('lightValue');
        $deviceReading->deviceId_fk = $request->input('deviceId_fk');

        $deviceReading->save();

        return response()->json($deviceReading);
    }

}
