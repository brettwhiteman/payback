<?php

namespace App\Http\Controllers;

use App\User;
use App\FriendRequest;
use Illuminate\Http\Request;

class FriendRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        return view('friend-requests.index', [
            'incoming' => $user->incomingFriendRequests()->with('from')->get(),
            'outgoing' => $user->outgoingFriendRequests()->with('to')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('friend-requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        $friendRequest = new FriendRequest;
        $friendRequest->from()->associate($from);
        $friendRequest->to()->associate($to);
        $friendRequest->save();

        return redirect()->route('friend-requests.index')->with('success', 'Friend request sent.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $friendRequest = FriendRequest::find($id);
        $redir = redirect()->route('friend-requests.index');

        if (!$friendRequest) {
            $redir->with('error', 'Friend request does not exist.');
        } else if ((bool)$request->accepted) {
            $friendRequest->from->friends()->attach($friendRequest->to);
            $friendRequest->to->friends()->attach($friendRequest->from);
            $redir->with('success', 'Friend request accepted.');
        } else {
            $redir->with('success', 'Friend request declined.');
        }

        // make sure any duplicate friend requests that may have sneaked in are cleaned up
        FriendRequest::where('from_id', $friendRequest->from->id)->where('to_id', $friendRequest->to->id)->delete();
        FriendRequest::where('to_id', $friendRequest->from->id)->where('from_id', $friendRequest->to->id)->delete();

        return $redir;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
