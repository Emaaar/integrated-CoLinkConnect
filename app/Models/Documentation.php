<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;

    protected $table = 'documentation';
    // protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'documentation_costing',
        'documentation_partner',
        'documentation_colinkIC',
        'documentation_timeline',
        'contract_num',
    ];
    protected $casts = [
        'documentation_costing' => 'integer',
        'documentation_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

