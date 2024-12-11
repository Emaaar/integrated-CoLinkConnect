<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Donation extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'donation';

    protected $primaryKey = 'donation_num';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'donor_name',
        'user_email',
        'prefer',
        'amount',
        'client_id',
    ];

    // Define relationship to User based on client_id
    public function userById()
    {
        return $this->belongsTo(User::class, 'client_id', 'client_id');
    }

    // Define relationship to User based on user_email
    public function userByEmail()
    {
        return $this->belongsTo(User::class, 'user_email', 'user_email');
    }
}
