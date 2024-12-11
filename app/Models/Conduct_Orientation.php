<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conduct_Orientation extends Model
{
    use HasFactory;

    protected $table = 'conduct_of_orientation';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'conduct_of_orientation_costing',
        'conduct_of_orientation_partner',
        'conduct_of_orientation_colinkIC',
        'conduct_of_orientation_timeline',
        'contract_num',
    ];
    protected $casts = [
        'conduct_of_orientation_costing' => 'integer',
        'conduct_of_orientation_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

