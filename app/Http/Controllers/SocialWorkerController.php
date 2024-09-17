<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Http\Request;

class SocialWorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search = $request->get('search');
        if ($search) {
            $data['social'] = Social::where('id', 'like', "%{$search}%")->get();
        } else {
            $data['social'] = Social::all();
        }
        return view('layouts.social-worker.index', $data);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Social $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $socialWorker = Social::find($id);
        return view('layouts.social-worker.edit', compact('social'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Social $socialWorker, $id)
    {
        //
        $socialWroker = Social::find($id);
        $socialWorker->role = $request->role;
        $socialWorker->save();
        return redirect()->route('social-worker.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Social $socialWorker)
    {
        //
        $socialWorker->delete();
    }
}
