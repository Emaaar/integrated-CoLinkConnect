<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordination_Materials extends Model
{
    use HasFactory;

    protected $table = 'coordination_of_materials';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'coordination_of_materials_costing',
        'coordination_of_materials_partner',
        'coordination_of_materials_colinkIC',
        'coordination_of_materials_timeline',
        'contract_num',
    ];
    protected $casts = [
        'coordination_of_materials_costing' => 'integer',
        'coordination_of_materials_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

