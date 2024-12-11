<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Partners_Information;

class Participants extends Model
{
    use HasFactory;

    protected $table = 'participants';

    protected $primaryKey = 'background_num';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'age',
        'gender',
        'education_status',
        'leadership_exp',
        'address',
        'contract_num',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}
