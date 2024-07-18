<?php

use App\Models\GroupChat;
use App\Models\GroupChatDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat', function ($user) {
    if ($user != null) {
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    } else {
        return false;
    }
});

Broadcast::channel('chat_private.{user_send}.{user_receive}', function ($user, $user_send, $user_receive) {
    // Log::debug("{$user}:{$user_send}:{$user_receive}");
    return $user?->id == $user_send || $user?->id == $user_receive;
});

Broadcast::channel('chat_group.{group_chat_id}', function ($user, $group_chat_id) {
    // Log::debug("{$user}:{$user_send}:{$user_receive}");
    if ($user) {
        $group_chat = GroupChat::findOrFail($group_chat_id);
        $users = $group_chat->GroupChatDetail()->pluck('user_id')->toArray();
        if ($user->id == $group_chat->leader || in_array($user->id, $users)) {
            return true;
        }
    }
    return false;
});

Broadcast::channel('users', function ($user) {
    return $user !== null;
});
