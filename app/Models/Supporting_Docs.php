<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supporting_Docs extends Model
{
    use HasFactory;

    protected $table = 'supporting_docs_coordination';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'supporting_docs_coordination_costing',
        'supporting_docs_coordination_partner',
        'supporting_docs_coordination_colinkIC',
        'supporting_docs_coordination_timeline',
        'contract_num',
    ];
    protected $casts = [
        'supporting_docs_coordination_costing' => 'integer',
        'supporting_docs_coordination_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

