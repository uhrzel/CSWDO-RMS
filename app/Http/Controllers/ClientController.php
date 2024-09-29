<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as GuzzleClient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller
{
    protected function validateClient(Request $request)
    {
        return $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle' => 'required|string',
            'suffix' => 'required|string',
            'building_number' => 'required|string',
            'street_name' => 'required|string',
            'barangay' => 'required|string',
            'age' => 'required|numeric',
            'date_of_birth' => 'nullable|date',
            'pob' => 'required|string',
            'sex' => 'nullable|string',
            'educational_attainment' => 'nullable|string',
            'civil_status' => 'nullable|string',
            'religion' => 'nullable|string',
            'nationality' => 'nullable|string',
            'occupation' => 'nullable|string',
            'monthly_income' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'source_of_referral' => 'nullable|string',
            'circumstances_of_referral' => 'nullable|string|max:65535',
            'family_background' => 'nullable|string|max:65535',
            'health_history' => 'nullable|string|max:65535',
            'economic_situation' => 'nullable|string|max:65535',
            'house_structure' => 'nullable|string',
            'floor' => 'nullable|string',
            'type' => 'nullable|string',
            'number_of_rooms' => 'nullable|string',
            'appliances' => 'nullable|array',
            'appliances.*' => 'nullable|string',
            'other_appliances' => 'nullable|string',
            'monthly_expenses' => 'nullable|string',
            'indicate' => 'nullable|string',
            'assessment' => 'nullable|string',
            'recommendation' => 'nullable|string',
            'tracking' => 'nullable|string',
            'problem_identification' => 'nullable|string',
            'data_gather' => 'nullable|string',
            'eval' => 'nullable|string',
            'control_number' => 'nullable|string',
            'problem_presented' => 'nullable|string|max:65535',
            'services' => 'nullable|array',
            'services.*' => 'nullable|string',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string',
            'home_visit' => 'nullable|date',
            'interviewee' => 'nullable|string',
            'interviewed_by' => 'nullable|string',
            'layunin' => 'nullable|string|max:65535',
            'result' => 'nullable|string|max:65535',
            'initial_findings' => 'nullable|string|max:65535',
            'initial_agreement' => 'nullable|string|max:65535',
            'assessment1' => 'nullable|string|max:65535',
            'case_management_evaluation' => 'nullable|string|max:65535',
            'case_resolution' => 'nullable|string|max:65535',
            'reviewing' => 'nullable|string',
            'approving' => 'nullable|string',
        ]);
    }

    public function updateStatus(Client $client, Request $request)
    {
        $statusType = $request->input('status_type');
        $statusValue = $request->input('status_value');

        $client->update([$statusType => $statusValue]);

        return redirect()->back()->with('success', "Client status updated to $statusValue.");
    }

    public function viewClosedClients()
    {
        $clients = Client::where('tracking', 'Approve')->get();
        return view('layouts.social-worker.view-closed-clients', compact('clients'));
    }
    public function viewOngoingClients()
    {
        $clients = Client::where('tracking', 'Re-access')->get();
        return view('layouts.social-worker.view-ongoing-clients', compact('clients'));
    }


    public function store(Request $request)
    {
        $validatedData = $this->validateClient($request);

        $validatedData['electricity'] = $request->input('electricity', '');
        $validatedData['water'] = $request->input('water', '');
        $validatedData['rent'] = $request->input('rent', '');
        $validatedData['other'] = $request->input('other', '');

        // Concatenate each category with its value
        $validatedData['monthly_expenses'] = [
            'Electricity' => $validatedData['electricity'],
            'Water' => $validatedData['water'],
            'Rent' => $validatedData['rent'],
            'Other' => $validatedData['other']
        ];

        $validatedData['monthly_expenses'] = json_encode($validatedData['monthly_expenses']);

        $validatedData['services'] = json_encode($request->input('services', []));
        $validatedData['requirements'] = json_encode($request->input('requirements', []));
        $validatedData['appliances'] = json_encode($request->input('appliances', []));
        $validatedData['other_appliances'] = $request->input('other_appliances', '');

        // Generate control number
        $latestClient = Client::latest()->first();
        if ($latestClient) {
            $lastControlNumber = $latestClient->control_number;
            $lastNumber = (int)substr($lastControlNumber, 4);
            $nextNumber = str_pad($lastNumber + 1, 7, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0000001';
        }

        $controlNumber = "APL " . $nextNumber;
        $validatedData['control_number'] = $controlNumber;

        // Handle optional fields for nationality and religion
        if ($request->input('nationality') === 'Other') {
            $validatedData['nationality'] = $request->input('other_nationality');
        } else {
            $validatedData['other_nationality'] = null;
        }

        if ($request->input('religion') === 'Other') {
            $validatedData['religion'] = $request->input('other_religion');
        } else {
            $validatedData['other_religion'] = null;
        }
        $validatedData['tracking'] = 'Re-access';
        // Create the client record
        $client = Client::create($validatedData);

        return response()->json([
            'message' => 'Form submitted successfully!',
            'control_number' => $controlNumber,
        ]);
    }


    public function caselist()
    {
        $clients = Client::where('tracking', 'Re-access')->get();
        return view('layouts.social-worker.index', compact('clients'));
    }

    public function generatePdf($id)
    {
        $client = Client::with('familyMembers')->findOrFail($id);

        // Load the view for the PDF
        $pdf = PDF::loadView('pdf.client', ['client' => $client]);

        // Download the PDF
        return $pdf->download('client-details.pdf');
    }


    public function show(Client $client)
    {
        $familyMembers = FamilyMember::where('client_id', $client->id)->get();
        return view('layouts.social-worker.index', compact('client', 'familyMembers'));
    }


    public function index()
    {
        $clients = Client::all();
        $trackingTotals = [
            'Problem Identification' => $clients->where('problem_identification', 'Done')->count(),
            'Data Gathering' => $clients->where('data_gather', 'Done')->count(),
            'Assessment' => $clients->where('assessment', 'Done')->count(),
            'Evaluation And Resolution' => $clients->where('eval', 'Done')->count(),
        ];

        return view('welcome', compact('clients', 'trackingTotals'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function getClientsByBarangay(Request $request)
    {
        $barangay = $request->input('barangay');
        $clients = Client::where('barangay', $barangay)->get();

        return response()->json($clients);
    }

    public function home()
    {
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

        return view('home', compact('barangays'));
    }


    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'middle' => 'nullable|string|max:255',
                'suffix' => 'nullable|string|max:10',
                'building_number' => 'nullable|string|max:255',
                'street_name' => 'nullable|string|max:255',
                'barangay' => 'nullable|string|max:255',
                'date_of_birth' => 'nullable|date',
                'pob' => 'nullable|string|max:255',
                'sex' => 'nullable|string|in:Male,Female',
                'educational_attainment' => 'nullable|string',
                'civil_status' => 'nullable|string',
                'religion' => 'nullable|string',
                'nationality' => 'nullable|string',
                'occupation' => 'nullable|string',
                'monthly_income' => 'nullable|string',
                'contact_number' => 'nullable|string',
                'source_of_referral' => 'nullable|string',
                'house_structure' => 'nullable|string',
                'floor' => 'nullable|string',
                'type' => 'nullable|string',
                'number_of_rooms' => 'nullable|string',
                'monthly_expenses' => 'nullable|string',
                'electricity' => 'nullable|string',
                'water' => 'nullable|string',
                'rent' => 'nullable|string',
                'other' => 'nullable|string',
                'indicate' => 'nullable|string',
                'tracking' => 'nullable|string',
                'other_appliances' => 'nullable|string',
                'appliances' => 'nullable|array',
                'appliances.*' => 'string',
                'circumstances_of_referral' => 'nullable|string',
                'family_background' => 'nullable|string',
                'health_history' => 'nullable|string',
                'economic_situation' => 'nullable|string',
                'problem_presented' => 'nullable|string',
                'problem_identification' => 'nullable|string',
                'services' => 'nullable|array',
                'services.*' => 'string',
                'home_visit' => 'nullable|string',
                'interviewee' => 'nullable|string',
                'layunin' => 'nullable|string',
                'resulta' => 'nullable|string',
                'initial_agreement' => 'nullable|string',
                'data_gather' => 'nullable|string',
                'assessment1' => 'nullable|string',
                'assessment' => 'nullable|string',
                'case_management_evaluation' => 'nullable|string',
                'case_resolution' => 'nullable|string',
                'reviewing' => 'nullable|string',
                'approving' => 'nullable|string',
                'eval' => 'nullable|string',
            ]);

            // Find the client by ID
            $client = Client::findOrFail($id);

            // Process fields with ucwords() if they are strings
            $fields = [
                'first_name',
                'last_name',
                'middle',
                'suffix',
                'building_number',
                'street_name',
                'barangay',
                'date_of_birth',
                'age',
                'barangay',
                'pob',
                'sex',
                'educational_attainment',
                'civil_status',
                'religion',
                'nationality',
                'occupation',
                'monthly_income',
                'contact_number',
                'source_of_referral',
                'house_structure',
                'floor',
                'type',
                'number_of_rooms',
                'indicate',
                'tracking',
                'other_appliances',
                'circumstances_of_referral',
                'family_background',
                'health_history',
                'economic_situation',
                'problem_presented',
                'problem_identification',
                'home_visit',
                'interviewee',
                'interviewed_by',
                'layunin',
                'resulta',
                'initial_agreement',
                'data_gather',
                'assessment1',
                'assessment',
                'case_management_evaluation',
                'case_resolution',
                'reviewing',
                'approving',
                'eval'
            ];

            foreach ($fields as $field) {
                if (is_string($request->input($field))) {
                    $client->$field = ucwords($request->input($field));
                }
            }

            // Handle the monthly_expenses as JSON data
            $monthlyExpenses = json_decode($client->monthly_expenses, true);

            // Update the monthly expenses fields, keeping existing values if new values are empty
            $monthlyExpenses['Electricity'] = $request->input('electricity', $monthlyExpenses['Electricity']);
            $monthlyExpenses['Water'] = $request->input('water', $monthlyExpenses['Water']);
            $monthlyExpenses['Rent'] = $request->input('rent', $monthlyExpenses['Rent']);
            $monthlyExpenses['Other'] = $request->input('other', $monthlyExpenses['Other']);

            // Re-encode the updated monthly expenses
            $client->monthly_expenses = json_encode($monthlyExpenses);
            // Handle appliances field if it's an array
            if ($request->has('appliances')) {
                $appliances = $request->input('appliances', []);
                // Remove duplicates
                $uniqueAppliances = array_unique($appliances);
                $client->appliances = json_encode($uniqueAppliances);
            }

            // Handle services field if it's an array and store as JSON

            if ($request->has('services')) {
                $services = $request->input('services', []);
                // Remove duplicates
                $uniqueServices = array_unique($services);
                $client->services = json_encode($uniqueServices);
            }


            // Send a message if the tracking status changes to 'Approve'
            if (in_array($client->tracking, ['Approve'])) {
                $this->sendMessage($client->contact_number, $client->first_name, $client->last_name, $client->tracking);
            }

            // Save the client model with updated data
            $client->save();

            return response()->json(['client' => $client]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error updating client: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while updating the client.'], 500);
        }
    }

    private function sendMessage($contactNumber, $firstName, $lastName)
    {
        $date = \Carbon\Carbon::now()->format('F j, Y');
        $apiKey = config('semaphore.api_key', env('SEMAPHORE_API_KEY'));
        $message = "Magandang araw, $firstName $lastName! Pwede na po kayong pumunta sa CSWDO simula sa $date para kunin ang inyong hinihinging tulong. Maaring magdala ng kahit anong valid ID. Narito ang address ng CSWDO Taguig: 
             \nCSWDO Taguig, 2nd Floor, Taguig City Hall, Brgy. Pinagsama, Taguig City. 
             \nMaraming salamat.";
        $senderName = 'CSWDORMS';

        // Check if API key is available
        if (empty($apiKey)) {
            Log::error('Semaphore API Key is missing.');
            return;
        }

        try {
            $response = Http::post('https://semaphore.co/api/v4/messages', [
                'apikey' => $apiKey,
                'number' => $contactNumber,
                'message' => $message,
                'sendername' => $senderName
            ]);

            $responseData = $response->json();

            Log::info('Semaphore API response: ' . $response->body());

            if (isset($responseData['error'])) {
                Log::error('Semaphore API error: ' . $responseData['error']);
            }
        } catch (\Exception $e) {
            Log::error('Request Exception: ' . $e->getMessage());
        }
    }


    /*     private function checkDeliveryStatus($messageId)
    {
        $apiKey = env('SEMAPHORE_API_KEY');

        $ch = curl_init();
        $parameters = [
            'apikey' => $apiKey,
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages/' . $messageId . '?' . http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            Log::error('cURL error: ' . curl_error($ch));
        } else {
            Log::info('Semaphore delivery status response: ' . $output);
        }

        curl_close($ch);

        return json_decode($output, true);
    } */


    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->back()->with('deleted_client_success', 'Client deleted successfully.');
    }

    public function receivedList()
    {
        $clients = Client::all();
        return view('received_list', compact('clients'));
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $origin = $request->input('origin');

        $clients = Client::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('first_name', 'like', "%$query%")
                ->orWhere('last_name', 'like', "%$query%")
                ->orWhere('middle', 'like', "%$query%")
                ->orWhere('suffix', 'like', "%$query%")
                ->orWhere('age', 'like', "%$query%")
                ->orWhere('address', 'like', "%$query%")
                ->orWhere('date_of_birth', 'like', "%$query%")
                ->orWhere('pob', 'like', "%$query%")
                ->orWhere('sex', 'like', "%$query%")
                ->orWhere('educational_attainment', 'like', "%$query%")
                ->orWhere('civil_status', 'like', "%$query%")
                ->orWhere('religion', 'like', "%$query%")
                ->orWhere('nationality', 'like', "%$query%")
                ->orWhere('occupation', 'like', "%$query%")
                ->orWhere('monthly_income', 'like', "%$query%")
                ->orWhere('contact_number', 'like', "%$query%")
                ->orWhere('source_of_referral', 'like', "%$query%")
                ->orWhere('circumstances_of_referral', 'like', "%$query%")
                ->orWhere('family_background', 'like', "%$query%")
                ->orWhere('health_history', 'like', "%$query%")
                ->orWhere('economic_situation', 'like', "%$query%")
                ->orWhere('house_structure', 'like', "%$query%")
                ->orWhere('floor', 'like', "%$query%")
                ->orWhere('type', 'like', "%$query%")
                ->orWhere('number_of_rooms', 'like', "%$query%")
                ->orWhere('appliances', 'like', "%$query%")
                ->orWhere('other_appliances', 'like', "%$query%")
                ->orWhere('monthly_expenses', 'like', "%$query%")
                ->orWhere('indicate', 'like', "%$query%")
                ->orWhere('assessment', 'like', "%$query%")
                ->orWhere('recommendation', 'like', "%$query%")
                ->orWhere('tracking', 'like', "%$query%")
                ->orWhere('problem_identification', 'like', "%$query%")
                ->orWhere('data_gather', 'like', "%$query%")
                ->orWhere('eval', 'like', "%$query%")
                ->orWhere('services', 'like', "%$query%")
                ->orWhere('control_number', 'like', "%$query%")
                ->orWhere('interviewee', 'like', "%$query%")
                ->orWhere('interviewed_by', 'like', "%$query%")
                ->orWhere('reviewing', 'like', "%$query%")
                ->orWhere('approving', 'like', "%$query%");
        })->get();

        if ($origin === 'dataentry') {
            return view('dataentry', compact('clients'));
        }
        return view('dataentry', compact('clients'));
    }
}
