<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat';
    protected $primaryKey = 'chat_id';
    public $timestamps = false;

    protected $fillable = [
        'timestamp',
        'sender_email',
        'receiver_email',
        'message',
        'client_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
