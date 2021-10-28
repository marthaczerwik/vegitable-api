<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceReading;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\DB;


class DeviceReadingController extends Controller
{

    /**
     * to get the most recent device readings for a particular bucket
     * TODO: add error handling if device readings have error field not null (meaning the sensors are not working correctly)
     */
    public function getCurrentDeviceReading($id){
        return DeviceReading::where('deviceId_fk', $id)->orderBy('deviceReadingId', 'desc')->first();
    }

    /**
     * To get historical data of a bucket
     */

    public function getHistoricalData($id, Request $request){
        $start = new DateTime(urldecode($request->startDate));
        $end = new DateTime(urldecode($request->endDate));

        //add 1 day to end variable so it includes that whole day as well
        $endPlusOne = $end->add(new DateInterval('P1D'));

        $readings = DeviceReading::selectRaw("0 as deviceReadingId, date(currentDateTime) as currentDateTimeStr, avg(phValue) as phValue, avg(temperatureValue) as temperatureValue, avg(ppmValue) as ppmValue, avg(waterValue) as waterValue, avg(humidityValue) as humidityValue, avg(lightValue) as lightValue, NULL as errorReading, 0 as deviceId_fk")
            ->where('deviceId_fk', $id)
            ->where('currentDateTime', '>=', $start)
            ->where('currentDateTime', '<=', $endPlusOne)
            ->groupBy(('currentDateTimeStr'))
            ->get();
            
        return response()->json($readings);

    } 

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
