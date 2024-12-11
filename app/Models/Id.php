<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Id extends Model
{
    use HasFactory;

    protected $table = 'id';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'id_costing',
        'id_partner',
        'id_colinkIC',
        'id_timeline',
        'contract_num',
    ];
    protected $casts = [
        'id_costing' => 'integer',
        'id_timeline' => 'date',
    ];
    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

