<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bucket;
use Illuminate\Support\Facades\DB;


class BucketController extends Controller
{

    /**
     * For creating a new bucket
     * Still need: methods to check if bucket name exists, and to not allow null values where required
     */
    public function createBucket(Request $request){
        $bucket = new Bucket();

        $bucket->bucketName = $request->input('bucketName');
        $bucket->createDateTime = now()->toDateTimeString(); 
        $bucket->lastUpdateDateTime = now()->toDateTimeString();
        $bucket->imageURL = $request->input('imageURL');
        $bucket->userId_fk = $request->input('userId_fk');
        $bucket->deviceId_fk = $request->input('deviceId_fk');


        $bucket->save();

        return response()->json($bucket);
    }

    /**
     * Update bucket - needs to use methods to validate
     */
    public function updateBucket(Request $request, $id){
        $updatedBucket = Bucket::find($id);
        $updatedBucket->bucketName = $request->input('bucketName');
        $updatedBucket->imageURL = $request->input('imageURL');
        $updatedBucket->lastUpdateDateTime = now()->toDateTimeString();
        $updatedBucket->deviceId_fk = $request->input('deviceId_fk');

        $updatedBucket->save();
        return response()->json($updatedBucket);

    }

    //get single bucket by bucket id
    public function getBucket($id){
        return Bucket::find($id);
    }

    //get all buckets of a user
    public function getBuckets($id){
        $buckets = Bucket::where('userId_fk', $id)->get();
        return response()->json($buckets);
    }

    //archive a bucket
    public function deleteBucket($id){
        $bucket = Bucket::find($id);
        $bucket->archiveDateTime = now()->toDateTimeString();
        $bucket->lastUpdateDateTime = now()->toDateTimeString();

        $bucket->save();
    }

}
