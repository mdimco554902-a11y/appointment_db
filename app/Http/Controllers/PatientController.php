<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    /**
     * Display a listing of patients.
     */
    public function index() 
    {
        // Using PatientID as the sorting key to match your schema
        $patients = Patient::oldest('PatientID')->get();
        return view('patients.index', compact('patients'));
    }

    /**
     * Store a newly created patient in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'FirstName'  => 'required|string|max:255',
            'MiddleName' => 'nullable|string|max:255',
            'LastName'   => 'required|string|max:255',
            'Email'      => 'required|email|unique:patients,Email',
            'Phone'      => 'nullable|string|max:20',
            'Age'        => 'nullable|integer|min:0|max:150',
            'BirthDate'  => 'nullable|date',
            'Gender'     => 'nullable|string|max:20',
            'Height'     => 'nullable|numeric|between:0,999.99',
            'BloodType'  => 'nullable|string|max:5',
            'Address'    => 'nullable|string|max:500',
        ]);

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'Patient added successfully!');
    }

    /**
     * Update the specified patient in storage.
     */
    public function update(Request $request, $id)
    {
        // We find by PatientID specifically
        $patient = Patient::where('PatientID', $id)->firstOrFail();

        $validated = $request->validate([
            'FirstName'  => 'required|string|max:255',
            'MiddleName' => 'nullable|string|max:255',
            'LastName'   => 'required|string|max:255',
            // Unique check ignoring the current patient's ID and specifying the 'PatientID' column
            'Email'      => 'required|email|unique:patients,Email,' . $id . ',PatientID',
            'Phone'      => 'nullable|string|max:20',
            'Age'        => 'nullable|integer|min:0|max:150',
            'BirthDate'  => 'nullable|date',
            'Gender'     => 'nullable|string|max:20',
            'Height'     => 'nullable|numeric|between:0,999.99',
            'BloodType'  => 'nullable|string|max:5',
            'Address'    => 'nullable|string|max:500',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')->with('success', 'Patient records updated successfully!');
    }

    /**
     * Remove the specified patient from storage.
     */
    public function destroy($id) 
    {
        // Finding by PatientID to ensure the correct record is deleted
        $patient = Patient::where('PatientID', $id)->firstOrFail();
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient record deleted.');
    }
}