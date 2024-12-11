<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordination_Venue extends Model
{
    use HasFactory;

    protected $table = 'coordination_for_venue';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'coordination_for_venue_costing',
        'coordination_for_venue_partner',
        'coordination_for_venue_colinkIC',
        'coordination_for_venue_timeline',

        'contract_num',
    ];
    protected $casts = [
        'coordination_for_venue_costing' => 'integer',
        'coordination_for_venue_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

