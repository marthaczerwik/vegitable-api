<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'Devices';
    protected $primaryKey = 'deviceId';
    public $timestamps = false;

    protected $fillable =[
        'deviceName',
        'createDateTime',
        'lastUpdateDateTime',
        'archiveDateTime',
        'userId_fk'
    ];

    protected $casts = [
        'userId_fk' => 'int'
    ];
}
