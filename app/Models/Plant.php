<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $table = 'Plants';
    protected $primaryKey = 'plantId';
    public $timestamps = false;
    
    protected $fillable =[
        'localId',
        'plantType',
        'plantName',
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
        'plantPhase',
        'createDateTime',
        'lastUpdateDateTime',
        'archiveDateTime',
        'imageURL',
        'bucketId_fk',
        'userId_fk'
    ];

    protected $casts = [
        'localId' => 'int',
        'bucketId_fk' => 'int',
        'temperatureMin' => 'float',
        'temperatureMax' => 'float',
        'phMin' => 'float',
        'phMax' => 'float',
        'ppmMin' => 'float',
        'ppmMax' => 'float',
        'lightMin' => 'float',
        'lightMax' => 'float',
        'humidityMin' => 'float',
        'humidityMax' => 'float',
        'userId_fk' => 'int'
    ];
}
