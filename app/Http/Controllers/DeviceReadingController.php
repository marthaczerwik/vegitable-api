<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceReading;

class DeviceReadingController extends Controller
{

    /**
     * to get the most recent device readings for a particular bucket
     * TODO: change return to custom object with HTTP status code and message and device reading obj within it
     * TODO: add error handling if device readings have error field not null (meaning the sensors are not working correctly)
     */
    public function getCurrentDeviceReading($id){
        return DeviceReading::where('deviceId_fk', $id)->orderBy('deviceReadingId', 'desc')->first();
    }

    /**
     * To get historical data of a bucket
     * TODO: write GET request to find all device readings for the particular bucket within a start and end date, and filtr by certain sensor
     */

    /*
    public function getHistoricalData($id, $startDate, $endDate, $sensorValue){
        return DeviceReading::where([
            ['bucketId_fk', $id],
            ['currentDateTime', '>=', $startDate],
            ['currentDateTime', '<=', $endDate],
            []
        ]);
    } */

    /**
     * To insert device readings from the ESP32 sensors to the db
     */
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
