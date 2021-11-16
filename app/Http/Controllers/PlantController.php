<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Bucket;

class PlantController extends Controller
{
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

        //get remote id of bucket
        $bucket = Bucket::where('userId_fk', $request->input('userId_fk'))
        ->where('localId', $request->input('bucketId_fk'))
        ->first();
        
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
        $plant->archiveDateTime = $request->input('archiveDateTime');
        $plant->imageURL = $request->input('imageURL');
        $plant->bucketId_fk = $bucket->bucketId;
        $plant->userId_fk = $request->input('userId_fk');

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
        $plant = Plant::where('userId_fk', $userId)
        ->where('localId', $plantId)
        ->first();

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
        $plant->lastUpdateDateTime = $request-> input('lastUpdateDateTime');
        $plant->imageURL = $request->input('imageURL');

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
    public function deletePlant(Request $request, $userId, $plantId){
        //find the requested plant
        $plant = Plant::where('userId_fk', $userId)
        ->where('localId', $plantId)
        ->first();

        //update the archive date
        $plant->archiveDateTime = $request-> input('archiveDateTime');
        $plant->lastUpdateDateTime = $request-> input('lastUpdateDateTime');

        //save to db
        $plant->save();

    }
}
