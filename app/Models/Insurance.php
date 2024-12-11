<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $table = 'insurance';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'insurance_costing',
        'insurance_partner',
        'insurance_colinkIC',
        'insurance_timeline',
        'contract_num',
    ];
    protected $casts = [
        'insurance_costing' => 'integer',
        'insurance_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

