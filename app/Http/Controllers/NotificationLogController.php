<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationLog;

class NotificationLogController extends Controller
{
    /**
     * Insert log into database
     * TODO: error handling if cannot be saved to db
     */
    public function createLog(Request $request){
        //create new notification log object
        $log = new NotificationLog();
        $log->localId =$reuest->input('notificationLogId');
        $log->notificationType = $request->input('notificationType');
        $log->notificationTime = $request->input('notificationTime');
        $log->createDateTime = $request->input('createDateTime');
        $log->lastUpdateDateTime = $request->input('lastUpdateDateTime');
        $log->bucketId_fk = $request->input('bucketId_fk');
        $log->userId_fk = $request->input('userId_fk');
        
        //insert to db
        $log->save();

        return response()->json($log);
    }
    
    
    /**
     * Return all notification logs
     */
    public function getLogs($bucketId, $userId){
      $logs = NotificationLog::where('bucketId_fk', $bucketId)
      ->where('userId_fk', $userId)
      ->get();
      return response()->json($logs);
    }
}
  