<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantType extends Model
{
    use HasFactory;

    protected $table = 'PlantTypes';
    protected $primaryKey = 'plantTypeId';
    public $timestamps = false;
    
    protected $fillable =[
        'localId',
        'plantTypeName',
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
        'userId_fk'
    ];

    protected $casts = [
        'localId' => 'int',
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
