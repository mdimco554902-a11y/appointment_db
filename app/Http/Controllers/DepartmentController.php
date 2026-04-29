<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'DepartmentName' => 'required|string|max:255',
            'Description'    => 'nullable|string'
        ]);

        Department::create([
            'DepartmentName' => $request->DepartmentName,
            'Description'    => $request->Description,
        ]);

        return redirect()->route('departments.index');
    }

    public function destroy($id)
    {
        Department::where('DeptID', $id)->delete();
        return redirect()->route('departments.index');
    }
}