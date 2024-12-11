<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordination_Speakers extends Model
{
    use HasFactory;

    protected $table = 'coordination_with_speakers';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'coordination_with_speakers_costing',
        'coordination_with_speakers_partner',
        'coordination_with_speakers_colinkIC',
        'coordination_with_speakers_timeline',
        'contract_num',
    ];
    protected $casts = [
        'coordination_with_speakers_costing' => 'integer',
        'coordination_with_speakers_timeline' => 'date',
    ];
    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

