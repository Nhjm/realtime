<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\UserCreate;
use App\Events\UserUpdate;
use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserDestroy;
use App\Events\UserUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    const VIEW_PATH = 'users.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest('id')->get();
        return view(self::VIEW_PATH . __FUNCTION__, compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        // dd($data);
        $data += ['password' => Hash::make(123)];
        $user = User::create($data);

        // broadcast(new UserCreated($user));

        return json_encode([
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = User::findOrFail(request('id'));
        return response()->json($user);
        // return json_decode($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);

        $user->update($request->all());

        // broadcast(new UserUpdated($user));

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $user = User::findOrFail(request('id'));

        // broadcast(new UserDeleted($user));
        // broadcast(new UserDestroy($user));

        $user->delete();

        return response()->json(['success' => true]);
    }
}
