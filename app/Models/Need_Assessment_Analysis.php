<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Need_Assessment_Analysis extends Model
{
    use HasFactory;

    protected $table = 'need_assessment_and_analysis';
    public $timestamps = false;

    protected $fillable = [
        'need_assessment_costing',
        'need_assessment_partner',
        'need_assessment_colinkIC',
        'need_assessment_timeline',
        'contract_num',
    ];

    protected $casts = [
        'need_assessment_costing' => 'integer',
        'need_assessment_timeline' => 'date',
    ];

    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}
