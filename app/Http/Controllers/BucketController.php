<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bucket;
use Illuminate\Support\Facades\DB;


class BucketController extends Controller
{
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
        $updatedBucket->temperatureMin = $request->input('temperatureMin');
        $updatedBucket->temperatureMax = $request->input('temperatureMax');
        $updatedBucket->phMin = $request->input('phMin');
        $updatedBucket->phMax = $request->input('phMax');
        $updatedBucket->ppmMin = $request->input('ppmMin');
        $updatedBucket->ppmMax = $request->input('ppmMax');
        $updatedBucket->lightMin = $request->input('lightMin');
        $updatedBucket->lightMax = $request->input('lightMax');
        $updatedBucket->humidityMin = $request->input('humidityMin');
        $updatedBucket->humidityMax = $request->input('humidityMax');

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
        $bucket->archiveDateTime = $request-> input('archiveDateTime');
        $bucket->lastUpdateDateTime = $request-> input('lastUpdateDateTime');

        //save updated bucket to db
        $bucket->save();
    }

}
