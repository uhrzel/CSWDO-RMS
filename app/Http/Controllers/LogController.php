<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Ensure you include the User model
use Carbon\Carbon; // Include Carbon for date formatting

class LogController extends Controller
{
    /**
     * Show the list of currently logged-in users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::where('role', 'social-worker')->get();


        foreach ($users as $user) {
            /*   $user->last_login = $user->last_login ?? Carbon::now(); // Use the current date if not set */
            $user->last_login;
        }

        return view('logs.index', compact('users'));
    }
}
