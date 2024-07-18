<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChatDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_chat_id',
        'user_id',
    ];

    public function GroupChat()
    {
        return $this->belongsTo(GroupChat::class);
    }
}
