<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    // Specify the table name
    protected $table = 'admin'; // Replace with the correct table name

    protected $primaryKey = 'admin_id'; // Admin's primary key
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    // protected $fillable = [
    //     'aduser_email',
    //     'password',
    // ];

    protected $fillable = [
        'aduser_email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

}