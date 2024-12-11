<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training_Design_Implementation extends Model
{
    use HasFactory;

    protected $table = 'trainig_design_and_implementation';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'trainig_design_and_implementation_costing',
        'trainig_design_and_implementation_partner',
        'trainig_design_and_implementation_colinkIC',
        'trainig_design_and_implementation_timeline',
        'contract_num',
    ];

    protected $casts = [
        'trainig_design_and_implementation_costing' => 'integer',
        'trainig_design_and_implementation_timeline' => 'date',

    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

