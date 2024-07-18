<?php

namespace App\Http\Controllers;

use App\Events\ChatGroup;
use App\Events\UserChatPrivate;
use App\Events\UserOnlined;
use App\Models\GroupChat;
use App\Models\GroupChatDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = User::query()->where('id', '<>', Auth::user()->id)->get();
        return view('chat.public', compact('user'));
    }

    public function send_message(Request $request)
    {
        broadcast(new UserOnlined($request->user(), $request->message));
        return json_encode('gửi thành công');
    }
    public function chat_private(User $user)
    {
        return view('chat.private', compact('user'));
    }

    public function send_private_message(string $id_user, Request $request)
    {
        broadcast(new UserChatPrivate($request->user(), User::findOrFail($id_user), $request->message));
        // dd($id_user, $request->user());
        return response()->json(['success' => $request->message]);
    }

    public function create_group_chat(request $request)
    {
        // dd($request->all());
        if (count($request->user_id) >= 1) {
            $GroupChat = GroupChat::create([
                'name' => $request->name,
                'leader' => auth::user()->id,
            ]);

            foreach ($request->user_id as $item) {
                GroupChatDetail::create([
                    'group_chat_id' => $GroupChat->id,
                    'user_id' => $item,
                ]);
            }

            return redirect()->back()->with('message', 'tạo nhóm thành công');
        }

        return redirect()->back()->with('message', 'ít nhất 1 thành viên ');
    }

    public function chat_group(string $id)
    {
        $group_chat = GroupChat::with('get_leader')->findOrFail($id);
        $users = $group_chat->Users;

        // dd($group_chat->leader);
        return view('chat.group', compact('users', 'group_chat'));
    }

    public function send_message_group(Request $request)
    {
        // dd($request->all());
        broadcast(
            new ChatGroup
            (
                $request->user(),
                groupChat::findOrFail($request->group_id),
                $request->message
            )
        );

        return response()->json([
            'success' => true
        ]);
    }
}
