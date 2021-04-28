<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'Notifications';
    protected $primaryKey = 'notificationId';
    public $timestamps = false;

    protected $fillable =[
        'dailyNotification',
        'dailyNotificationTime',
        'alertNotification',
        'deviceNotification',
        'createDateTime',
        'lastUpdateDateTime',
        'archiveDateTime',
        'userId_fk'
    ];

    protected $casts = [
        'userId_fk' => 'int',
        'dailyNotification' => 'bool', //or should be int??
        'alertNotification' => 'bool',
        'deviceNotification' => 'bool'
    ];
}
