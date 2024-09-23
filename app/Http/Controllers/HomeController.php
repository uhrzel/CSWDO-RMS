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
            'Cembo',
            'Central Bicutan',
            'Central Signal Village',
            'Comembo',
            'East Rembo',
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
            'Rizal',
            'Palingon',
            'Pembo',
            'Pinagsama',
            'Pitogo',
            'Post Proper Northside',
            'Post Proper Southside',
            'San Miguel',
            'Santa Ana',
            'South Daang Hari',
            'South Signal Village',
            'South Cembo',
            'Tuktukan',
            'Tanyag',
            'Upper Bicutan',
            'Ususan',
            'Wawa',
            'Western Bicutan',
            'West Rembo',
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

    /*    public function getMostRequestedServices(Request $request)
    {
        $barangay = $request->input('barangay');

        // Fetch the most requested services
        $mostRequestedServices = DB::table('clients')
            ->select(DB::raw('JSON_UNQUOTE(service_name) AS service, COUNT(*) as count'))
            ->join(DB::raw('(SELECT id, JSON_UNQUOTE(JSON_EXTRACT(services, "$[*]")) AS service_name FROM clients WHERE barangay = ?) AS service_table'), 'clients.id', '=', 'service_table.id')
            ->groupBy('service')
            ->orderBy('count', 'DESC')
            ->limit(5)
            ->setBindings([$barangay])
            ->get();

        // Define the mapping of raw services to service names
        $requirements = [
            'Burial Assistance' => ['Burial', 'Financial', 'Valid ID', 'Barangay Clearance.', 'Medical Certificate.', 'Incident Report.', 'Funeral Contract.', 'Death Certificate.'],
            'Crisis Intervention Unit' => ['Valid ID', 'Residence Certificate Or Barangay Clearance', 'Clinical Abstract/Medical Certificate', 'Police Report Or Incident Report', 'Funeral Contract And Registered Death Certificate. (if Applicable)', 'Electric Fan'],
            'Solo Parent Services' => ['Solo Parent = Agency Referral', 'Residency Cert.', 'Medical Cert.', 'Billing Proof', 'Birth Cert.', 'ID Copy', 'Senior Citizen ID (60+)'],
            'Pre-marriage Counseling' => ['Pre-marriage Counseling = Valid ID', 'Birth Certificate', 'CENOMAR', 'Barangay Clearance', 'Passport-sized Photos'],
            'After-Care Services' => ['After-Care Services = Valid ID', 'Birth Certificate.', 'Residence Certificate.', 'SCSR', 'Medical Records'],
            'Poverty Alleviation Program' => ['Poverty Alleviation Program = Valid ID', 'Residence Certificate', 'Income Certificate', 'SCSR.', 'Application Form'],
        ];

        // Transform the most requested services
        $requestedServices = $mostRequestedServices->map(function ($serviceCount) use ($requirements) {
            $serviceArray = json_decode($serviceCount->service); // Decode the JSON array
            $matchedService = null;

            // Check for service requirements
            foreach ($requirements as $serviceName => $req) {
                // Check if any requirement is present in the service array
                if (array_intersect($req, $serviceArray)) {
                    $matchedService = $serviceName;
                    break;
                }
            }

            // Set the matched service or keep the original if not matched
            $serviceCount->service = $matchedService ?? $serviceCount->service;
            return $serviceCount;
        });

        return response()->json($requestedServices);
    }
 */

    public function getMostRequestedServices(Request $request)
    {
        $barangay = $request->input('barangay');


        $mostRequestedServices = DB::table('clients')
            ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(services, "$[*]")) AS service, COUNT(*) as count'))
            ->where('barangay', $barangay)
            ->groupBy('service')
            ->orderBy('count', 'DESC')
            ->limit(5)
            ->get();


        $requirements = [
            'Burial Assistance' => ['Burial', 'Financial', 'Crisis Intervention Unit = Valid ID', 'Barangay Clearance.', 'Medical Certificate.', 'Incident Report.', 'Funeral Contract.', 'Death Certificate.'],
            'Crisis Intervention Unit' => ['Valid ID', 'Residence Certificate Or Barangay Clearance', 'Clinical Abstract/Medical Certificate', 'Police Report Or Incident Report', 'Funeral Contract And Registered Death Certificate. (if Applicable)'],
            'Solo Parent Services' => ['Solo Parent = Agency Referral', 'Residency Cert.', 'Medical Cert.', 'Billing Proof', 'Birth Cert.', 'ID Copy', 'Senior Citizen ID (60+)'],
            'Pre-marriage Counseling' => ['Pre-marriage Counseling = Valid ID', 'Birth Certificate', 'CENOMAR', 'Barangay Clearance', 'Passport-sized Photos'],
            'After-Care Services' => ['After-Care Services = Valid ID', 'Birth Certificate.', 'Residence Certificate.', 'SCSR', 'Medical Records'],
            'Poverty Alleviation Program' => ['Poverty Alleviation Program = Valid ID', 'Residence Certificate', 'Income Certificate', 'SCSR.', 'Application Form'],
        ];


        $unrelatedServices = [
            'Refrigerator',
            'Washing Machine',
            'Television',
            'Microwave',
            'Air Conditioner',
            'Electric Fan'
        ];


        $requestedServices = $mostRequestedServices->map(function ($serviceCount) use ($requirements, $unrelatedServices) {
            $serviceArray = json_decode($serviceCount->service); // Decode the JSON array
            $matchedService = null;


            $filteredServiceArray = array_diff($serviceArray, $unrelatedServices);


            foreach ($requirements as $serviceName => $req) {

                if (array_intersect($req, $filteredServiceArray)) {
                    $matchedService = $serviceName;
                    break;
                }
            }

            $serviceCount->service = $matchedService ?? $serviceCount->service;
            return $serviceCount;
        });

        return response()->json($requestedServices);
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
