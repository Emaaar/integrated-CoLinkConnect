<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue_Recce extends Model
{
    use HasFactory;

    protected $table = 'venue_recce';
    public $timestamps = false;

    protected $fillable = [
        'venue_recce_costing',
        'venue_recce_partner',
        'venue_recce_colinkIC',
        'venue_recce_timeline',
        'contract_num',
    ];
    protected $casts = [
        'venue_recce_costing' => 'integer',
        'venue_recce_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

