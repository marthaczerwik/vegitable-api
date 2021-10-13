<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $table = 'NotificationSettings';
    protected $primaryKey = 'notificationSettingId';
    public $timestamps = false;

    protected $fillable =[
        'localId',
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
        'localId' => 'int',
        'userId_fk' => 'int',
        'dailyNotification' => 'bool',
        'alertNotification' => 'bool',
        'deviceNotification' => 'bool'
    ];
}
