<?php

namespace App\Http\Controllers;

use App\Models\DailySchedule;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DailyScheduleController extends Controller
{
    public function index()
    {
        // Fetch schedules with doctor info
        $schedules = DailySchedule::with('doctor')->orderBy('AvailableDate', 'asc')->get();
        $doctors = Doctor::all();
        return view('schedules.index', compact('schedules', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'DoctorID' => 'required|exists:doctors,DoctorID',
            'AvailableDate' => 'required|date|after_or_equal:today',
            'Shift' => 'required|in:AM,PM,Full Day',
            'MaxCapacity' => 'required|integer|min:1'
        ]);

        DailySchedule::create($request->all());

        return redirect()->back()->with('success', 'Schedule posted successfully!');
    }

    public function update(Request $request, $id)
    {
        $schedule = DailySchedule::findOrFail($id);
        $schedule->update($request->all());
        return redirect()->back()->with('success', 'Schedule updated!');
    }

    public function destroy($id)
    {
        DailySchedule::destroy($id);
        return redirect()->back()->with('success', 'Schedule removed!');
    }
}