<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Partners_Information;

class Proposed_Intervention extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'proposed_intervention';

    protected $primaryKey = 'pintervention_num';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'type_intervention',
        'venue',
        'startdate',
        'enddate',
        'days',
        'duration',
        'objectives',
        'output',
        'contract_num',
    ];

    // Define relationship to Partners Information
    public function partnersInformation()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }

    public function peopleInvolve()
    {
        return $this->hasOne(People_Involve::class, 'contract_num', 'contract_num');
    }
}

