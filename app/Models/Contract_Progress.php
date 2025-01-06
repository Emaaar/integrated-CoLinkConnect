<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract_Progress extends Model
{
    use HasFactory;

    protected $table = 'contract_progress';

    protected $fillable = [
        'contract_num',
        'is_processing',
        'is_pending',
        'is_done'
    ];

    public function partnerInformation()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}
