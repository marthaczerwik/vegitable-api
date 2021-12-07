<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    //database informatio
    protected $table = 'Users';
    protected $primaryKey = 'userId';
    public $timestamps = false;

    //map to fields found in the database table
    protected $fillable =[
        'localId',
        'userEmail',
        'userPassword',
        'userFirstName',
        'userLastName',
        'imageURL', 
        'createDateTime',
        'lastUpdateDateTime',
        'archiveDateTime'
    ];

    //cast any variables to the proper data type, as they may come in as strings
    protected $casts = [
        'localId' => 'int'
    ];

   










    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*
    protected $fillable = [
        'name',
        'email',
        'password',
    ]; */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*
    protected $hidden = [
        'password',
        'remember_token',
    ]; */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /*
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/
}
