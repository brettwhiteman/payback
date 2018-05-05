<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('friends.index')->with('friends', auth()->user()->friends);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $friend = User::findOrFail($id);

        $user->friends()->detach($friend);
        $friend->friends()->detach($user);

        return redirect()->route('friends.index')->with('success', 'Friend removed.');
    }
}
