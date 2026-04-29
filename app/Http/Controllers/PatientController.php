<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index() {
        $patients = Patient::oldest('PatientID')->get();
        return view('patients.index', compact('patients'));
    }

    public function store(Request $request)
    {
        // 1. Validate the data - Added MiddleName as nullable per documentation
        $validated = $request->validate([
            'FirstName'  => 'required|string|max:255',
            'MiddleName' => 'nullable|string|max:255',
            'LastName'   => 'required|string|max:255',
            'Email'      => 'required|email|unique:patients,Email',
            'Phone'      => 'nullable|string|max:20',
        ]);

        // 2. Create the patient using the validated data
        \App\Models\Patient::create($validated);

        // 3. Redirect back with success
        return redirect()->route('patients.index')->with('success', 'Patient added successfully!');
    }

    public function destroy($id) {
        Patient::findOrFail($id)->delete();
        return redirect()->route('patients.index');
    }
}