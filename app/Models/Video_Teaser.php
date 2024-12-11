<?php

namespace App\Models;

use App\Models\Partners_Information;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video_Teaser extends Model
{
    use HasFactory;

    protected $table = 'video_teaser';
    public $timestamps = false;

    protected $fillable = [
        // Fields
        'video_teaser_costing',
        'video_teaser_partner',
        'video_teaser_colinkIC',
        'video_teaser_timeline',
        'contract_num',
    ];
    protected $casts = [
        'video_teaser_costing' => 'integer',
        'video_teaser_timeline' => 'date',
    ];

    // Define relationship to Partners Information
    public function partner()
    {
        return $this->belongsTo(Partners_Information::class, 'contract_num', 'contract_num');
    }
}

