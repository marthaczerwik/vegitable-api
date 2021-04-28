<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bucket extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'Buckets';
    protected $primaryKey = 'bucketId';

    protected $fillable =[
        'bucketName',
        'temperatureMin',
        'temperatureMax',
        'phMin',
        'phMax',
        'ppmMin',
        'ppmMax',
        'lightMin',
        'lightMax',
        'humidityMin',
        'humidityMax',
        'createDateTime',
        'lastUpdateDateTime',
        'archiveDateTime',
        'imageURL',
        'userId_fk',
        'deviceId_fk'
    ];

    protected $casts = [
        'userId_fk' => 'int',
        'deviceId_fk' => 'int',
        'temperatureMin' => 'float',
        'temperatureMax' => 'float',
        'phMin' => 'float',
        'phMax' => 'float',
        'ppmMin' => 'float',
        'ppmMax' => 'float',
        'lightMin' => 'float',
        'lightMax' => 'float',
        'humidityMin' => 'float',
        'humidityMax' => 'float'
    ];
}
