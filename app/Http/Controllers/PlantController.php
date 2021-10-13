<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Bucket;

class PlantController extends Controller
{
    
    /**
     * Function to update the thresholds (min and max) for the bucket overall, based on the threshold values of all the plants within it.
     * TODO: move into android code
     */
    /*
    public function updateThresholds($bucketId){

        $bucket = Bucket::find($bucketId);

        $plantCollection = Plant::where('bucketId_fk', $bucketId)->get();

        //if the bucket is not empty
        if ($plantCollection){
            $bucket->temperatureMin = $plantCollection->pluck('temperatureMin')->max();
            $bucket->temperatureMax = $plantCollection->pluck('temperatureMax')->min();
            $bucket->phMin = $plantCollection->pluck('phMin')->max();
            $bucket->phMax = $plantCollection->pluck('phMax')->min();
            $bucket->ppmMin = $plantCollection->pluck('ppmMin')->max();
            $bucket->ppmMax = $plantCollection->pluck('ppmMax')->min();
            $bucket->lightMin = $plantCollection->pluck('lightMin')->max();
            $bucket->lightMax = $plantCollection->pluck('lightMax')->min();
            $bucket->humidityMin = $plantCollection->pluck('humidityMin')->max();
            $bucket->humidityMax = $plantCollection->pluck('humidityMax')->min();
        }

        return $bucket;
    }
    */

    /**
     * Return single plant to viewplant data
     */
    public function getPlant($userId, $plantId){
        return Plant::where('userId_fk', $userId)
        ->where('localId', $plantId)
        ->get();
    }

    /**
     * For creating a new plant
     * TODO: error handling if plant already exists (optional)
     * TODO: error handling if cannot be saved to db
     * TODO: add user id once in db and if needed
     */
    public function createPlant(Request $request){
        //create new plant object
        $plant = new Plant();
        
        //assign values based on request input
        $plant->localId = $request->input('plantId');
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
        $plant->createDateTime = $request-> input('createDateTime');
        $plant->lastUpdateDateTime = $request-> input('lastUpdateDateTime');
        $plant->imageURL = $request->input('imageURL');
        $plant->bucketId_fk = $request->input('bucketId_fk');
        
        /* moving to android code
        //TODO: add try catch to ensure nothing gets saved unless update is possible

            //get bucket the plant is in
            $bucket = Bucket::find($request->input('bucketId_fk'));
            
            //update the bucket threshold values
            $bucket = $this->updateThresholds($request->input('bucketId_fk'));

            //save the created plant in the db
            $plant->save();

            //save the updated bucket to the db
            $bucket->save();
        */

        //save the created plant in the db
        $plant->save();

        //return the plant
        return response()->json($plant);
    }

    /**
     * To update a plant when on edit plant page 
     * TODO: error handling if cannot be saved to db, if plant id doesn't exist (optional)
     */
    public function updatePlant(Request $request, $userId, $plantId){

        //find plant in the db
        $plant = Plant::find($id);

        //update values based on request input
        $plant->localId = $request->input('plantId');
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
        $plant->lastUpdateDateTime = $request-> input('lastUpdateDateTime');
        $plant->imageURL = $request->input('imageURL');
        $plant->bucketId_fk = $request->input('bucketId_fk');

        //save the plant in db
        $plant->save();

        //return updated plant
        return response()->json($plant);
    }

     /**
      * To retrieve all plants from one bucket
      */
    public function getPlants($userId, $bucketId){
        //find all plants in the requestedbucket and return plant(s)
        $plants = Plant::where('userId_fk', $userId)
        ->where('bucketId_fk', $bucketId)
        ->get();

        return response()->json($plants);
    }

    /**
     * To archive a plant
     * TODO: error handling if cannot be saved to db, if plant id doesn't exist (optional)
     */
    public function deletePlant($userId, $plantId){
        //find the requested plant
        $plant = Plant::where('userId_fk', $userId)
        ->where('localId', $plantId)
        ->get();

        //update the archive date
        //$plant->archiveDateTime = now()->toDateTimeString();
        //$plant->lastUpdateDateTime = now()->toDateTimeString();
        $plant->archiveDateTime = $request-> input('archiveDateTime');
        $plant->lastUpdateDateTime = $request-> input('lastUpdateDateTime');

        //save to db
        $plant->save();

        /* moving to android code
        //get bucket the plant is in
        $bucket = Bucket::where('bucketId', $plant->bucketId_fk)->get();

        //update the bucket threshold values and save the returned bucket
        $bucket = $this->updateThresholds($bucket->bucketId);
        $bucket->save();
        */

    }
}
