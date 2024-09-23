<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FamilyMember;
use App\Models\Social;
use Illuminate\Support\Facades\DB;
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

        $barangays = [
            'Bagumbayan',
            'Bambang',
            'Calzada',
            'Central Bicutan',
            'Central Signal Village',
            'Fort Bonifacio',
            'Hagonoy',
            'Ibayo-Tipas',
            'Katuparan',
            'Ligid-Tipas',
            'Lower Bicutan',
            'Maharlika Village',
            'Napindan',
            'New Lower Bicutan',
            'North Daang Hari',
            'North Signal Village',
            'Palingon-Tipas',
            'Pinagsama',
            'San Miguel',
            'Santa Ana',
            'South Daang Hari',
            'South Signal Village',
            'Tanyag',
            'Upper Bicutan',
            'Ususan',
            'Wawa',
            'Western Bicutan',
            'Central Signal',
            'Bagong Tanyag'
        ];


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

        return view('home', compact('totalClients', 'completedClients', 'incompleteClients', 'totalFamilyMembers', 'totalSocialWorkers', 'barangays'));
    }

    public function getIncomeBrackets(Request $request)
    {
        $barangay = $request->get('barangay');
        $clients = Client::where('barangay', $barangay)->get();

        return response()->json(['clients' => $clients]);
    }

    public function getMostRequestedServices(Request $request)
    {
        $barangay = $request->input('barangay');

        $mostRequestedServices = DB::table('clients')
            ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(services, "$[*]")) as service'), DB::raw('COUNT(*) as count'))
            ->where('barangay', $barangay)
            ->groupBy('service')
            ->orderBy('count', 'DESC')
            ->limit(5)
            ->get();

        return response()->json($mostRequestedServices);
    }



    public function getGenderDistribution(Request $request)
    {
        $barangay = $request->input('barangay');

        $genderData = DB::table('clients')
            ->select(DB::raw('sex AS gender, COUNT(*) as count'))
            ->where('barangay', $barangay)
            ->groupBy('sex')
            ->get()
            ->pluck('count', 'gender');

        return response()->json([
            'male' => $genderData->get('Male', 0),
            'female' => $genderData->get('Female', 0),
            'others' => $genderData->get('Other', 0),
        ]);
    }

    public function getAgeGroupServices(Request $request)
    {
        $barangay = $request->input('barangay');


        $ageGroups = [
            '0-17' => 0,
            '18-64' => 0,
            '65+' => 0,
        ];


        $clients = DB::table('clients')
            ->where('barangay', $barangay)
            ->get();

        foreach ($clients as $client) {
            $age = intval($client->age);
            if ($age <= 17) {
                $ageGroups['0-17']++;
            } elseif ($age <= 64) {
                $ageGroups['18-64']++;
            } else {
                $ageGroups['65+']++;
            }
        }

        return response()->json($ageGroups);
    }

    public function blank()
    {
        return view('layouts.blank-page');
    }
}
