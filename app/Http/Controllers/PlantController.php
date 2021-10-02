<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Bucket;

class PlantController extends Controller
{
    
    /**
     * Function to update the thresholds (min and max) for the bucket overall, based on the threshold values of all the plants within it.
     * This is to ensure that the bucket's overall thresholds can support all plants.
     * Retrieves all plants associated with that bucket and grabs a collection of min and max values, setting the overall bucket min/max appropriately.
     * TODO: add error handling if the newly added plant does not work with the bucket thresholds
     * TODO: change return to custom object with HTTP status code and message and bucket id
     */
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

    /**
     * Return single plant to viewplant data
     * TODO: confirm if need to change return to custom object with HTTP status code, message, and plant object within that object
     */
    public function getPlant($id){
        return Plant::find($id);
    }

    /**
     * For creating a new plant
     * TODO: error handling if plant already exists (optional)
     * TODO: validation (optional if front end handles this)
     * TODO: change return to custom object with HTTP status code and message and plant id
     * TODO: error handling if cannot be saved to db
     */
    public function createPlant(Request $request){
        //create new plant object
        $plant = new Plant();
        
        //assign values based on request input
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
              
        //TODO: add try catch to ensure nothing gets saved unless update is possible

            //get bucket the plant is in
            $bucket = Bucket::find($request->input('bucketId_fk'));
            
            //update the bucket threshold values
            $bucket = $this->updateThresholds($request->input('bucketId_fk'));

            //save the created plant in the db
            $plant->save();

            //save the updated bucket to the db
            $bucket->save();

        //return the plant
        return response()->json($plant);
    }

    /**
     * To update a plant when on edit plant page 
     * TODO: validation (optional if front end handles this)
     * TODO: change return to custom object with HTTP status code and message and plant id
     * TODO: error handling if cannot be saved to db, if plant id doesn't exist (optional)
     */
    public function updatePlant(Request $request, $id){

        //find plant in the db
        $plant = Plant::find($id);

        //update values based on request input
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

        //save the plant in db
        $plant->save();

        //return updated plant
        return response()->json($plant);
    }

     /**
      * To retrieve all plants from one bucket
      * TODO: confirm if need to change return to custom object with HTTP status code, message, and plant array within that object
      */
    public function getPlants($id){
        //find all plants in the requestedbucket and return plant(s)
        $plants = Plant::where('bucketId_fk', $id)->get();
        return response()->json($plants);
    }

    /**
     * To archive a plant
     * TODO: change return to custom object with HTTP status code and message 
     * TODO: error handling if cannot be saved to db, if plant id doesn't exist (optional)
     */
    public function deletePlant($id){
        //find the requested plant
        $plant = Plant::find($id);

        //update the archive date
        $plant->archiveDateTime = now()->toDateTimeString();
        $plant->lastUpdateDateTime = now()->toDateTimeString();

        //save to db
        $plant->save();

        //get bucket the plant is in
        $bucket = Bucket::where('bucketId', $plant->bucketId_fk)->get();

        //update the bucket threshold values and save the returned bucket
        $bucket = $this->updateThresholds($bucket->bucketId);
        $bucket->save();

    }
}
