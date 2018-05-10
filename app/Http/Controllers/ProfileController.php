<?php

namespace App\Http\Controllers;

use Auth;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index')->with([
            'timezones' => DateTimeZone::listIdentifiers()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'password' => 'nullable|string|min:6|confirmed',
            'timezone' => 'required|timezone'
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->timezone = $request->timezone;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated.');
    }
}
