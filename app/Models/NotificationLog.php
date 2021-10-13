<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;

    protected $table = 'NotificationLogs';
    protected $primaryKey = 'notificationLogId';
    public $timestamps = false;

    protected $fillable =[
      'localId',
      'notificationType',
      'notificationTime',
      'createDateTime',
      'lastUpdateDateTime',
      'notificationMessage',
      'bucketId_fk',
      'userId_fk'
    ];

    protected $casts = [
      'localId' => 'int',
      'bucketId_fk' => 'int',
      'userId_fk' => 'int'
    ];
}
