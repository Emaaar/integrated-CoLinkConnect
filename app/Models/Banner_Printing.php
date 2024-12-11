<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner_Printing extends Model
{
    use HasFactory;

    protected $table = 'banner_printing';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'banner_printing_costing',
        'banner_printing_partner',
        'banner_printing_colinkIC',
        'banner_printing_timeline',
        'contract_num',
    ];
    protected $casts = [
        'banner_printing_costing' => 'integer',
        'banner_printing_timeline' => 'date',
    ];


    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

