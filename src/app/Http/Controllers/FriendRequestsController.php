<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\FriendRequest;
use Illuminate\Http\Request;

class FriendRequestsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('friend-requests.index', [
            'incoming' => $user->incomingFriendRequests()->with('from')->get(),
            'outgoing' => $user->outgoingFriendRequests()->with('to')->get()
        ]);
    }

    public function create()
    {
        return view('friend-requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email' => 'Invalid email address.',
            'exists' => 'Account does not exist.'
        ]);

        $from = auth()->user();
        $to = User::where('email', $request->email)->first();
        $redirCreate = redirect()->route('friend-requests.create');

        if ($to == $from) {
           return $redirCreate->with('error', 'Lol.');
        } else if (FriendRequest::where('from_id', $from->id)->where('to_id', $to->id)->first()) {
            return $redirCreate->with('error', 'Friend request already exists.');
        } else if (FriendRequest::where('from_id', $to->id)->where('to_id', $from->id)->first()) {
            return $redirCreate->with('error', $to->email . ' has sent you a friend request already, go and accept this instead.');
        } else if ($from->friends()->find($to->id)) {
            return $redirCreate->with('error', $to->email . ' is already a friend.');
        }

        if ($from->id > $to->id) {
            $idStr = $to->id . '_' . $from->id;
        } else {
            $idStr = $from->id . '_' . $to->id;
        }

        $friendRequest = new FriendRequest;
        $friendRequest->from_id = $from->id;
        $friendRequest->to_id = $to->id;
        $friendRequest->hash = hash('sha256', $idStr);
        $friendRequest->save();

        return redirect()->route('friend-requests.index')->with('success', 'Friend request sent.');
    }

    public function update(Request $request, $id)
    {
        $friendRequest = FriendRequest::find($id);
        $redir = redirect()->route('friend-requests.index');

        if (!$friendRequest) {
            $redir->with('error', 'Friend request does not exist.');
        } else if ((bool)$request->accepted) {
            DB::transaction(function() use(&$friendRequest) {
                $friendRequest->from->friends()->attach($friendRequest->to);
                $friendRequest->to->friends()->attach($friendRequest->from);
                $friendRequest->delete();
            });

            $redir->with('success', 'Friend request accepted.');
        } else {
            $redir->with('success', 'Friend request declined.');
            $friendRequest->delete();
        }

        return $redir;
    }

    public function destroy($id)
    {
        $friendRequest = FriendRequest::find($id);
        $redir = redirect()->route('friend-requests.index');

        if (!$friendRequest) {
            $redir->with('error', 'Friend request does not exist.');
        } else {
            $friendRequest->delete();
            $redir->with('success', 'Friend request deleted.');
        }

        return $redir;
    }
}
