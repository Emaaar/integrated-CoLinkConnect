<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents_Consent extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'parents_consent';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'parents_consent_costing',
        'parents_consent_partner',
        'parents_consent_colinkIC',
        'parents_consent_timeline',
        'contract_num',
    ];
    protected $casts = [
        'parents_consent_costing' => 'integer',
        'parents_consent_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

