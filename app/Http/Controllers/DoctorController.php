<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    /**
     * Display a listing of the doctors.
     */
    public function index()
    {
        // Eager load 'department' to ensure the blue badges show correct names
        $doctors = Doctor::with('department')->get();
        $departments = Department::all();
        
        return view('doctors.index', compact('doctors', 'departments'));
    }

    /**
     * Store a newly created doctor in storage.
     */
    public function store(Request $request)
    {
        // Validate that the keys match your HTML form 'name' attributes exactly
        $validated = $request->validate([
            'FirstName'      => 'required|string|max:255',
            'MiddleName'     => 'nullable|string|max:255',
            'LastName'       => 'required|string|max:255',
            'Specialization' => 'required|string|max:255',
            'DeptID'         => 'required|exists:departments,DeptID',
        ]);

        try {
            Doctor::create($validated);
            return redirect()->route('doctors.index')->with('success', 'Doctor registered successfully!');
        } catch (\Exception $e) {
            // This logs the error to storage/logs/laravel.log if it fails again
            Log::error("Doctor Store Error: " . $e->getMessage());
            return back()->withErrors(['error' => 'Database Error: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Update the specified doctor in storage.
     */
    public function update(Request $request, $id)
    {
        // Ensure we find the doctor by their DoctorID
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'FirstName'      => 'required|string|max:255',
            'MiddleName'     => 'nullable|string|max:255',
            'LastName'       => 'required|string|max:255',
            'Specialization' => 'required|string|max:255',
            'DeptID'         => 'required|exists:departments,DeptID',
        ]);

        try {
            $doctor->update($validated);
            return redirect()->route('doctors.index')->with('success', 'Doctor profile updated successfully!');
        } catch (\Exception $e) {
            Log::error("Doctor Update Error: " . $e->getMessage());
            return back()->withErrors(['error' => 'Update Failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified doctor from storage.
     */
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor removed successfully!');
    }
}