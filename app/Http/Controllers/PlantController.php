<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Bucket;

class PlantController extends Controller
{
    
    /*
    public function updateThresholds($plantId, $bucketId){
        //get bucket object
        $bucket = Bucket::find($bucketId);

        //get plant object
        $plant = Plant::find($plantId);

        //if bucket has more than one plant..
            //get values from plant object, add to bucket values (min/max), divide by 2, and update bucket values
            $bucket->temperatureMin = ((($bucket->temperatureMin) + ($plant->temperatureMin)) / 2);
            $bucket->temperatureMax = ((($bucket->temperatureMin) + ($plant->temperatureMin)) / 2);
            $bucket->phMin = ((($bucket->temperatureMin) + ($plant->temperatureMin)) / 2);
            $bucket->phMax = ((($bucket->temperatureMin) + ($plant->temperatureMin)) / 2);
            $bucket->ppmMin = ((($bucket->temperatureMin) + ($plant->temperatureMin)) / 2);
            $bucket->ppmMax = ((($bucket->temperatureMin) + ($plant->temperatureMin)) / 2);
            $bucket->lightMin = ((($bucket->temperatureMin) + ($plant->temperatureMin)) / 2);
            $bucket->lightMax = ((($bucket->temperatureMin) + ($plant->temperatureMin)) / 2);
            $bucket->humidityMin = ((($bucket->temperatureMin) + ($plant->temperatureMin)) / 2);
            $bucket->humidityMax = ((($bucket->temperatureMin) + ($plant->temperatureMin)) / 2);
            $bucket->lastUpdateDateTime = now()->toDateTimeString();

    }
*/


    /**
     * Return single plant to viewplant data
     */
    public function getPlant($id){
        return Plant::find($id);
    }

    /**
     * For creating a new plant
     * Still need: methods to check if plant exists, methods to not allow null values where required
     */
    public function createPlant(Request $request){
        $plant = new Plant();
        
        $plant->plantType = $request->input('plantType');
        $plant->plantName = $request->input('plantName');
        $plant->temperatureMin = $request->input('temperatureMin');
        $plant->temperatureMax = $request->input('temperatureMax');
        $plant->phMin = $request->input('phMin');
        $plant->phMax = $request->input('phMax');
        $plant->ppmMin = $request->input('ppmMin');
        $plant->ppmMax = $request->input('ppmMax');
        $plant->lightMin = $request->input('lightMin');
        $plant->lightMax = $request->input('lightMax');
        $plant->humidityMin = $request->input('humidityMin');
        $plant->humidityMax = $request->input('humidityMax');
        $plant->plantPhase = $request->input('plantPhase');
        $plant->createDateTime = now()->toDateTimeString();
        $plant->lastUpdateDateTime = now()->toDateTimeString();
        $plant->imageURL = $request->input('imageURL');
        $plant->bucketId_fk = $request->input('bucketId_fk');


        $plant->save();
                
        //get bucket the plant is in
        $bucket = Bucket::find($request->input('bucketId_fk'));

        //update the bucket values
        //TEMPORARY SOLUTION FOR PROTOTYPING - PROPER CALCULATION NEEDED
        $bucket->temperatureMin = (($bucket->temperatureMin) + ($request->input('temperatureMin'))) / 2;
        $bucket->temperatureMax = (($bucket->temperatureMax) + ($request->input('temperatureMax'))) / 2;
        $bucket->phMin = (($bucket->phMin) + ($request->input('phMin'))) /2;
        $bucket->phMax = (($bucket->phMax) + ($request->input('phMax'))) /2;
        $bucket->ppmMin = (($bucket->ppmMin) + ($request->input('ppmMin'))) /2;
        $bucket->ppmMax = (($bucket->ppmMax) + ($request->input('ppmMax'))) /2;
        $bucket->lightMin = (($bucket->lightMin) + ($request->input('lightMin'))) /2;
        $bucket->lightMax = (($bucket->lightMax) + ($request->input('lightMax'))) / 2;
        $bucket->humidityMin = (($bucket->humidityMin) + ($request->input('humidityMin'))) /2;
        $bucket->humidityMax = (($bucket->humidityMax) + ($request->input('humidityMax'))) /2;
        $bucket->lastUpdateDateTime = now()->toDateTimeString();

        $bucket->save();

        //return the plant only
        return response()->json($plant);
    }

    /**
     * To update a plant when on edit plant page 
     */
    public function updatePlant(Request $request, $id){
        $plant = Plant::find($id);

        $plant->plantType = $request->input('plantType');
        $plant->plantName = $request->input('plantName');
        $plant->temperatureMin = $request->input('temperatureMin');
        $plant->temperatureMax = $request->input('temperatureMax');
        $plant->phMin = $request->input('phMin');
        $plant->phMax = $request->input('phMax');
        $plant->ppmMin = $request->input('ppmMin');
        $plant->ppmMax = $request->input('ppmMax');
        $plant->lightMin = $request->input('lightMin');
        $plant->lightMax = $request->input('lightMax');
        $plant->humidityMin = $request->input('humidityMin');
        $plant->humidityMax = $request->input('humidityMax');
        $plant->plantPhase = $request->input('plantPhase');
        $plant->lastUpdateDateTime = now()->toDateTimeString();
        $plant->imageURL = $request->input('imageURL');
        $plant->bucketId_fk = $request->input('bucketId_fk');

        $plant->save();
        return response()->json($plant);

    }

     /**
      * To retrieve all plants from one bucket
      */
    public function getPlants($id){
        $plants = Plant::where('bucketId_fk', $id)->get();
        return response()->json($plants);
    }

    /**
     * To archive a plant
     */
    public function deletePlant($id){
        $plant = Plant::find($id);
        $plant->archiveDateTime = now()->toDateTimeString();
        $plant->lastUpdateDateTime = now()->toDateTimeString();

        $plant->save();
    }
}
