<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Partners_Information;

class Services_Offered extends Authenticatable
{
    use HasFactory, Notifiable;

    // Specify the table name
    protected $table = 'services_offered';

    protected $primaryKey = 'transaction_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'name_service',
        'cost',
        'incharge',
        'dateordered',
        'datecomplete',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Define relationship to Partners_Information
    public function Partners_Information()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num');
    }
}

