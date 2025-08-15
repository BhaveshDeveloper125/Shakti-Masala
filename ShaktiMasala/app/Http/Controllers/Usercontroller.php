<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class Usercontroller extends Controller
{
    public function UserRegistration(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:0|max:255',
        ]);

        try {
            if (User::where('email', $validation['email'])->exists()) {
                return redirect()->back()->with('email', 'This email already exists, please choose the other email');
            } else {
                $validation['password'] = bcrypt($validation['password']);
                $save = User::create($validation);
                if (!$save) {
                    return redirect()->back()->with('error', 'oops, something went wrong, the data are not registered, please try again later');
                }
                return redirect()->back()->with('success', 'Your Data are saved successfully');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
