<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Secretariat extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'secretariat';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'secretariat_costing',
        'secretariat_partner',
        'secretariat_colinkIC',
        'secretariat_timeline',
        'contract_num',
    ];
    protected $casts = [
        'secretariat_costing' => 'integer',
        'secretariat_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

