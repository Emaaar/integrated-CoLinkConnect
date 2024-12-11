<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Partners_Information;

class Intervention_Assessment extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'intervention_assessment';

    protected $primaryKey = 'intervention_num';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'pic_success',
        'kgap',
        'sgap',
        'tdgap',
        'issues_concerns',
        'contract_num',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

