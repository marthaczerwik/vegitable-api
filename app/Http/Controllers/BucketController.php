<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bucket;
use Illuminate\Support\Facades\DB;


class BucketController extends Controller
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
     * For creating a new bucket
     * TODO: error handling if bucket already exists (optional)
     * TODO: validation (optional if front end handles this)
     * TODO: change return to custom object with HTTP status code and message and bucket id
     * TODO: error handling if cannot be saved to db
     */
    public function createBucket(Request $request){
        //create new bucket object
        $bucket = new Bucket();

        //assign values based on request input
        $bucket->bucketName = $request->input('bucketName');
        $bucket->createDateTime = now()->toDateTimeString(); 
        $bucket->lastUpdateDateTime = now()->toDateTimeString();
        $bucket->imageURL = $request->input('imageURL');
        $bucket->userId_fk = $request->input('userId_fk');
        $bucket->deviceId_fk = $request->input('deviceId_fk');

        //insert bucket to db
        $bucket->save();

        return response()->json($bucket);
    }

    /**
     * To update a bucket when on edit bucket page 
     * TODO: validation (optional if front end handles this)
     * TODO: change return to custom object with HTTP status code and message and bucket id
     * TODO: error handling if cannot be saved to db, if bucket id doesn't exist (optional)
     */
    public function updateBucket(Request $request, $id){
        //find bucket
        $updatedBucket = Bucket::find($id);

        //update bucket based on request input
        $updatedBucket->bucketName = $request->input('bucketName');
        $updatedBucket->imageURL = $request->input('imageURL');
        $updatedBucket->lastUpdateDateTime = now()->toDateTimeString();
        $updatedBucket->deviceId_fk = $request->input('deviceId_fk');

        //TODO: add try catch to ensure nothing gets saved unless update is possible (if existing plants have incompatible min/max with the new bucket min/max, need to return error)
            
            //update the bucket threshold values
            $updatedBucket = $this->updateThresholds($id);

            //save the updated bucket to the db
            $updatedBucket->save();

        return response()->json($updatedBucket);
    }

    /**
     * Return single bucket to view bucket data
     * TODO: confirm if need to change return to custom object with HTTP status code, message, and bucket object within that object
     */    
    public function getBucket($id){
        return Bucket::find($id);
    }

     /**
      * To retrieve all buckets from one user
      * TODO: confirm if need to change return to custom object with HTTP status code, message, and bucket array within that object
      */
    public function getBuckets($id){
        $buckets = Bucket::where('userId_fk', $id)->get();
        return response()->json($buckets);
    }

    /**
     * To archive a bucket
     * TODO: change return to custom object with HTTP status code and message 
     * TODO: error handling if cannot be saved to db, if bucket id doesn't exist (optional)
     */
    public function deleteBucket($id){
        //find bucket
        $bucket = Bucket::find($id);

        //archive
        $bucket->archiveDateTime = now()->toDateTimeString();
        $bucket->lastUpdateDateTime = now()->toDateTimeString();

        //save updated bucket to db
        $bucket->save();
    }

}
