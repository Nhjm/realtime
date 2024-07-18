<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'leader'
    ];

    public function GroupChatDetail()
    {
        return $this->hasMany(GroupChatDetail::class);
    }

    public function Users()
    {
        return $this->hasManyThrough(User::class, GroupChatDetail::class, 'group_chat_id', 'id', 'id', 'user_id');
    }

    public function get_leader()
    {
        return $this->belongsTo(User::class, 'leader');
    }
}
