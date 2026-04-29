<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the doctors.
     */
    public function index()
    {
        // Eager load 'department' to display DepartmentName in the table badges
        $doctors = Doctor::with('department')->get();
        $departments = Department::all();
        return view('doctors.index', compact('doctors', 'departments'));
    }

    /**
     * Store a newly created doctor in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'FName' => 'required|string|max:255',
            'MName' => 'nullable|string|max:255',
            'LName' => 'required|string|max:255',
            'Specialization' => 'required|string|max:255',
            'DeptID' => 'required|exists:departments,DeptID',
        ]);

        Doctor::create($validated);

        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully!');
    }

    /**
     * Update the specified doctor in storage.
     * This fixes the "undefined method update" error.
     */
    public function update(Request $request, $id)
    {
        // Find the doctor by the primary key (DoctorID)
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'FName' => 'required|string|max:255',
            'MName' => 'nullable|string|max:255',
            'LName' => 'required|string|max:255',
            'Specialization' => 'required|string|max:255',
            'DeptID' => 'required|exists:departments,DeptID',
        ]);

        // Update the record in the database
        $doctor->update($validated);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully!');
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