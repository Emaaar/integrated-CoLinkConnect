<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Specify the primary key
    protected $primaryKey = 'client_id'; // Primary key column name
    public $incrementing = true; // Use true since client_id is an auto-incrementing bigint
    protected $keyType = 'int'; // Specify the key type as integer

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false; // Disable timestamps since not using created_at and updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_email',
        'firstname',
        'lastname',
        'organization',
        'password',
        'otp',
        'otp_created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', // Hide password when serializing
        'remember_token', // Hide remember token
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'otp' => 'integer', // Cast otp to integer type
        'otp_created_at' => 'datetime', // Cast otp_created_at to datetime type
        'password' => 'hashed', // Automatically hash the password
    ];

        // Define relationship to Partners_Information
    public function partners_information()
    {
        return $this->hasMany(Partners_Information::class, 'client_id');
    }

    // Define relationship to Donations by client_id
    public function donationsById()
    {
        return $this->hasMany(Donation::class, 'client_id', 'client_id');
    }

    // Define relationship to Donations by user_email
    public function donationsByEmail()
    {
        return $this->hasMany(Donation::class, 'user_email', 'user_email');
    }

}
