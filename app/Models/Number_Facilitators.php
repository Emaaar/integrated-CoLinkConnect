<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number_Facilitators extends Model
{
    use HasFactory;

    protected $table = 'number_of_facilitators';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'number_of_facilitators_costing',
        'number_of_facilitators_partner',
        'number_of_facilitators_colinkIC',
        'number_of_facilitators_timeline',
        'contract_num',
    ];
    protected $casts = [
        'number_of_facilitators_costing' => 'integer',
        'number_of_facilitators_timeline' => 'date',
    ];

    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

