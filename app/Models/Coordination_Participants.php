<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordination_Participants extends Model
{
    use HasFactory;

    protected $table = 'coordination_with_participants';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'coordination_with_participants_costing',
        'coordination_with_participants_partner',
        'coordination_with_participants_colinkIC',
        'coordination_with_participants_timeline',
        'contract_num',
    ];
    protected $casts = [
        'coordination_with_participants_costing' => 'integer',
        'coordination_with_participants_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

