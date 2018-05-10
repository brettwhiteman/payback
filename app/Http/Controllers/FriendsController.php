<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function index()
    {
        return view('friends.index')->with('friends', auth()->user()->friends);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $friend = User::findOrFail($id);

        if ($friend->hasObligationFromCurrentUser() || $friend->hasObligationToCurrentUser()) {
            return redirect()->route('friends.index')->with('error', 'You must clear your balance before removing friend');
        }

        DB::transaction(function() use(&$user, &$friend) {
            $user->friends()->detach($friend);
            $friend->friends()->detach($user);
        });

        return redirect()->route('friends.index')->with('success', 'Friend removed.');
    }
}
