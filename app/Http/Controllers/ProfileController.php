<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',  // Fix typo from baranggay to barangay
            'birthday' => 'required|date',
            'age' => 'required|integer|min:0',
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Update the user's profile details
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->city = $request->input('city');
        $user->barangay = $request->input('barangay'); // Ensure it matches your input name
        $user->birthday = $request->input('birthday');
        $user->age = $request->input('age');

        // Debugging output to see if the data is being set correctly
        logger()->info('User data being saved:', $user->toArray());

        // Save the updated user data to the database
        if ($user->save()) {
            return redirect()->route('profile.edit')->with('status', 'Profile updated successfully!');
        } else {
            return redirect()->back()->withErrors(['error' => 'Profile update failed.']);
        }
    }



    public function changepassword()
    {
        return view('profile.changepassword', ['user' => Auth::user()]);
    }

    public function password(Request $request)
    { {
            $request->validate([
                'current_password' => ['required', 'string'],
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password Sebelumnya Salah!']);
            }

            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            return back()->with('status', 'Password berhasil Diubah!');
        }
    }
}
