<?php

namespace App\Http\Controllers;

use App\Models\GroupChat;
use App\Models\GroupChatDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('id', '<>', Auth::user()->id)->get();
        $my_group_chats = GroupChat::where('leader', Auth::user()->id)->get();
        $group_chats = GroupChatDetail::where('user_id', Auth::user()->id)
            ->with('GroupChat')
            ->get();

        return view(
            'home',
            compact(
                'users',
                'my_group_chats',
                'group_chats'
            )
        );
    }
}
