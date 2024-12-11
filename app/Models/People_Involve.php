<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Partners_Information;

class People_Involve extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'people_involve';

    protected $primaryKey = 'involve_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'leadfaci',
        'secondfaci',
        'thirdfaci',
        'sponsor',
        'vip',
        'working_com',
        'observers',
        'contract_num',
    ];

    // Define relationship to Partners Information
    public function partnersInformation()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }

    public function proposedIntervention()
    {
        return $this->belongsTo(Proposed_Intervention::class, 'contract_num', 'contract_num');
    }
}

