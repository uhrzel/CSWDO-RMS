<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyMember;
use App\Models\Client;


class FamilyMemberController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'fam_lastname' => 'required|string|max:255',
            'fam_firstname' => 'required|string|max:255',
            'fam_middlename' => 'nullable|string|max:255',
            'fam_relationship' => 'nullable|string|max:255',
            'fam_birthday' => 'nullable|date',
            'fam_age' => 'nullable|integer',
            'fam_gender' => 'nullable|string|max:10',
            'fam_status' => 'nullable|string|max:255',
            'fam_education' => 'nullable|string|max:255',
            'fam_occupation' => 'nullable|string|max:255',
            'fam_income' => 'nullable|numeric',
        ]);

        FamilyMember::create($request->all());

        return back()->with('add_success', 'Family member added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fam_lastname' => 'required|string|max:255',
            'fam_firstname' => 'required|string|max:255',
            'fam_middlename' => 'nullable|string|max:255',
            'fam_relationship' => 'nullable|string|max:255',
            'fam_birthday' => 'nullable|date',
            'fam_age' => 'nullable|integer',
            'fam_gender' => 'nullable|string|max:10',
            'fam_status' => 'nullable|string|max:255',
            'fam_education' => 'nullable|string|max:255',
            'fam_occupation' => 'nullable|string|max:255',
            'fam_income' => 'nullable|numeric',
        ]);

        $familyMember = FamilyMember::findOrFail($id);
        $familyMember->update($request->all());

        return back()->with('update_success', 'Family member update successfully.');
    }

    public function destroy($id)
    {
        $familyMember = FamilyMember::findOrFail($id);
        $familyMember->delete();

        return back()->with('delete_success', 'Family member deleted successfully.');
    }
}
