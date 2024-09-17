<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FamilyMember;
use App\Models\Social;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch the total number of clients
        $totalClients = Client::count();
        $totalFamilyMembers = FamilyMember::count();

        $completedClients = Client::where('problem_identification', 'Done')
            ->where('data_gather', 'Done')
            ->where('assessment', 'Done')
            ->where('eval', 'Done')
            ->count();

        // Fetch the total number of clients who have not completed all stages
        $incompleteClients = Client::where(function ($query) {
            $query->where('problem_identification', '!=', 'Done')
                ->orWhere('data_gather', '!=', 'Done')
                ->orWhere('assessment', '!=', 'Done')
                ->orWhere('eval', '!=', 'Done');
        })->count();

        $totalSocialWorkers = Social::where('role', 'social-worker')->count();



        // Pass the data to the view
        return view('home', compact('totalClients', 'completedClients', 'incompleteClients', 'totalFamilyMembers', 'totalSocialWorkers'));
    }
    public function blank()
    {
        return view('layouts.blank-page');
    }
}
