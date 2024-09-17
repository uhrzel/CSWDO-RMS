<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Http\Request;

class SocialWorkerAccountController extends Controller
{
   
    public function index()
    {
        // Fetch all users with the role of 'social-worker'
        $socialWorkers = Social::where('role', 'social-worker')->get();

        // Pass the data to the view
        return view('admin.index', compact('socialWorkers'));
    }

    public function update(Request $request, $id)
    {
        $worker = Social::find($id);
        if (!$worker) {
            return redirect()->route('admin.index')->with('error', 'Social worker not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $worker->name = $request->input('name');
        $worker->email = $request->input('email');
        $worker->save();

        return redirect()->route('admin.index')->with('success', 'Social worker details updated successfully.');
    }

    public function destroy($id)
    {
        $worker = Social::find($id);
        if ($worker) {
            $worker->delete();
            return redirect()->route('admin.index')->with('success', 'Social worker account deleted successfully.');
        } else {
            return redirect()->route('admin.index')->with('error', 'Social worker not found.');
        }
    }
}
