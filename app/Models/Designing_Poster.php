<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designing_Poster extends Model
{
    use HasFactory;

    protected $table = 'designing_of_poster';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'designing_of_poster_costing',
        'designing_of_poster_partner',
        'designing_of_poster_colinkIC',
        'designing_of_poster_timeline',
        'contract_num',
    ];

    protected $casts = [
        'designing_of_poster_costing' => 'integer',
        'designing_of_poster_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

