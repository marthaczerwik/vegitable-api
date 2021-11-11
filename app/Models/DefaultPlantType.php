<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultPlantType extends Model
{
    use HasFactory;

    protected $table = 'DefaultPlantTypes';
    protected $primaryKey = 'plantTypeId';
    public $timestamps = false;
    
    protected $fillable =[
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
        'lastUpdateDateTime'
    ];

    protected $casts = [
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
