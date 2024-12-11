<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    use HasFactory;

    protected $table = 'partners_information';
    protected $primaryKey = 'contract_num';
    protected $fillable = [
        'total',  // Add other fields as necessary
        // 'other_field1',
        // 'other_field2',
    ];
}
