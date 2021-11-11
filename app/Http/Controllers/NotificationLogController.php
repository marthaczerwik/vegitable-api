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
        $log->localId = null;
        $log->notificationType = $request->input('notificationType');
        $log->notificationTime = $request->input('notificationTime');
        $log->notificationMessage = $request->input('notificationMessage');
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
    public function getLogs($userId, $type){
      $logs = NotificationLog::where('userId_fk', $userId)
      ->where('notificationType', $type)
      ->get();
      return response()->json($logs);
    }
}
  