<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceReading extends Model
{
    use HasFactory;

    protected $table = 'DeviceReadings';
    protected $primaryKey = 'deviceReadingId';
    public $timestamps = false;

    protected $fillable =[
        'currentDateTime',
        'phValue',
        'temperatureValue',
        'ppmValue',
        'waterValue',
        'humidityValue',
        'lightValue',
        'deviceId_fk'
    ];

    protected $casts = [
        'deviceId_fk' => 'int',
        'phValue' => 'float',
        'temperatureValue' => 'float',
        'ppmValue' => 'float',
        'waterValue' => 'float',
        'humidityValue' => 'float',
        'lightValue' => 'float'
    ];
}
