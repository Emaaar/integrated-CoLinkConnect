<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tshirt_Printing extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'tshirt_printing';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'tshirt_printing_costing',
        'tshirt_printing_partner',
        'tshirt_printing_colinkIC',
        'tshirt_printing_timeline',
        'contract_num',
    ];
    protected $casts = [
        'tshirt_printing_costing' => 'integer',
        'tshirt_printing_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

