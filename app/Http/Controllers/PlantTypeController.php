<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantType;

class PlantTypeController extends Controller
{
    
    /**
     * Return single plant type
     */
    public function getPlantType($userId, $plantTypeId){
        return PlantType::where('userId_fk', $userId)
        ->where('localId', $plantTypeId)
        ->get();
    }

    /**
     * For creating a new plant type (custom plant types will be saved in the database)
     * TODO: error handling if plant type already exists (optional)
     * TODO: error handling if cannot be saved to db
     */
    public function createPlantType(Request $request){
        //create new plant type object
        $plantType = new PlantType();
        
        //assign values based on request input
        $plantType->localId = $request->input('plantTypeId');
        $plantType->plantTypeName = $request->input('plantTypeName');
        $plantType->temperatureMin = $request->input('temperatureMin');
        $plantType->temperatureMax = $request->input('temperatureMax');
        $plantType->phMin = $request->input('phMin');
        $plantType->phMax = $request->input('phMax');
        $plantType->ppmMin = $request->input('ppmMin');
        $plantType->ppmMax = $request->input('ppmMax');
        $plantType->lightMin = $request->input('lightMin');
        $plantType->lightMax = $request->input('lightMax');
        $plantType->humidityMin = $request->input('humidityMin');
        $plantType->humidityMax = $request->input('humidityMax');
        $plantType->createDateTime = $request->input('createDateTime');
        $plantType->lastUpdateDateTime = $request->input('lastUpdateDateTime');
        $plantType->userId_fk = $request->input('userId_fk');
              
        //TODO: add try catch to ensure nothing gets saved unless update is possible

        //save the created plant type in the db
        $plantType->save();

        //return the plant type
        return response()->json($plantType);
    }

     /**
      * To retrieve all plant types the user has created
      */
    public function getPlantTypes($userId){
        $plantTypes = PlantType::where('userId_fk', $userId)->get();
        return response()->json($plantTypes);
    }

}
