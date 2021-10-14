<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bucket;
use Illuminate\Support\Facades\DB;


class BucketController extends Controller
{
    /**
     * Function to update the thresholds (min and max) for the bucket overall, based on the threshold values of all the plants within it.
     * TODO: move to android code
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
    }*/

    /**
     * For creating a new bucket
     * TODO: error handling if cannot be saved to db
     */
    public function createBucket(Request $request){
        //create new bucket object
        $bucket = new Bucket();

        //assign values based on request input
        $bucket->localId = $request->input('bucketId');
        $bucket->bucketName = $request->input('bucketName');
        //$bucket->createDateTime = now()->toDateTimeString(); 
        //$bucket->lastUpdateDateTime = now()->toDateTimeString();
        $bucket->createDateTime = $request-> input('createDateTime');
        $bucket->lastUpdateDateTime = $request-> input('lastUpdateDateTime');
        $bucket->imageURL = $request->input('imageURL');
        $bucket->userId_fk = $request->input('userId_fk');
        $bucket->deviceId_fk = $request->input('deviceId_fk');

        //insert bucket to db
        $bucket->save();

        return response()->json($bucket);
    }

    /**
     * To update a bucket when on edit bucket page 
     * TODO: error handling if cannot be saved to db, if bucket id doesn't exist (optional)
     */
    public function updateBucket(Request $request, $userId, $bucketId){
        //find bucket
        $updatedBucket = Bucket::where('userId_fk', $userId)
        ->where('localId', $bucketId)
        ->first();


        //update bucket based on request input
        $updatedBucket->bucketName = $request->input('bucketName');
        $updatedBucket->imageURL = $request->input('imageURL');
        $updatedBucket->lastUpdateDateTime = $request->input('lastUpdateDateTime');
        $updatedBucket->deviceId_fk = $request->input('deviceId_fk');


        /* MOVING THIS TO ANDROID CODE
        //TODO: add try catch to ensure nothing gets saved unless update is possible (if existing plants have incompatible min/max with the new bucket min/max, need to return error)
            
            //update the bucket threshold values
            $updatedBucket = $this->updateThresholds($id);
        */

        //save the updated bucket to the db
        $updatedBucket->save();
        //echo $updatedBucket;

        return response()->json($updatedBucket);
    }

    /**
     * Return single bucket to view bucket data
     */    
    public function getBucket($userId, $bucketId){
        return Bucket::where('userId_fk', $userId)
        ->where('localId', $bucketId)
        ->get();
    }

     /**
      * To retrieve all buckets from one user
      */
    public function getBuckets($userId){
        $buckets = Bucket::where('userId_fk', $userId)->get();
        return response()->json($buckets);
    }

    /**
     * To archive a bucket
     * TODO: error handling if cannot be saved to db, if bucket id doesn't exist (optional)
     */
    public function deleteBucket(Request $request, $userId, $bucketId){
        //find bucket
        $bucket = Bucket::where('userId_fk', $userId)
        ->where('localId', $bucketId)
        ->first();

        //archive
        //$bucket->archiveDateTime = now()->toDateTimeString();
        //$bucket->lastUpdateDateTime = now()->toDateTimeString();
        $bucket->archiveDateTime = $request-> input('archiveDateTime');
        $bucket->lastUpdateDateTime = $request-> input('lastUpdateDateTime');

        //save updated bucket to db
        $bucket->save();
    }

}
