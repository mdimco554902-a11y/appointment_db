<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare Plus | Daily Schedules</title>
    <style>
        body { margin: 0; display: flex; font-family: 'Segoe UI', Tahoma, sans-serif; background: #f4f7f6; color: #333; }
        .sidebar { width: 260px; background: #1a2e1a; color: white; height: 100vh; position: fixed; padding: 20px; display: flex; flex-direction: column; box-sizing: border-box; }
        .sidebar h2 { color: #fff; font-size: 22px; margin-bottom: 5px; }
        .sidebar .role { color: #88a088; font-size: 12px; margin-bottom: 30px; text-transform: uppercase; }
        .nav-menu { flex: 1; }
        .nav-item { padding: 12px 15px; color: #bdc3c7; text-decoration: none; display: block; margin-bottom: 5px; border-radius: 5px; transition: 0.3s; }
        .nav-item:hover, .nav-item.active { background: #2d4d2d; color: white !important; font-weight: bold; }
        .btn-logout { background: transparent; border: 1px solid #445544; color: #bdc3c7; padding: 10px; cursor: pointer; width: 100%; margin-top: 20px; border-radius: 5px; }

        .main { margin-left: 260px; padding: 40px; width: calc(100% - 260px); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 28px; }

        .content-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #f4f7f6; color: #95a5a6; font-size: 13px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #f4f7f6; font-size: 14px; }
        
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .badge-am { background: #e3f2fd; color: #1976d2; }
        .badge-pm { background: #fff3e0; color: #f57c00; }
        .badge-full { background: #e8f5e9; color: #2e7d32; }

        .btn-create { background: #27ae60; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold; border: none; cursor: pointer; }
        
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000; }
        .modal-container { background: white; padding: 30px; border-radius: 10px; width: 420px; }
        .modal-input { width: 100%; padding: 10px; margin: 8px 0 15px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
    </style>
</head>
<body>

<div class="sidebar">
        <h2>HealthCare Plus</h2>
        <div class="role">{{ auth()->user()->isAdmin() ? 'Schedule' : 'Patient Portal' }}</div>
        
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">Dashboard</a>
            
            @if(auth()->user()->isAdmin())
                <a href="{{ route('services.index') }}" class="nav-item {{ request()->is('services*') ? 'active' : '' }}">Medical Services</a>
                <a href="{{ route('schedules.index') }}" class="nav-item {{ request()->is('schedules*') ? 'active' : '' }}">Daily Schedules</a>
                <a href="{{ route('patients.index') }}" class="nav-item {{ request()->is('patients*') ? 'active' : '' }}">Patient Records</a>
            @endif

            <a href="{{ route('appointments.index') }}" class="nav-item {{ request()->is('appointments*') ? 'active' : '' }}">Appointments</a>

            @if(auth()->user()->isAdmin())
                <a href="{{ route('doctors.index') }}" class="nav-item {{ request()->is('doctors*') ? 'active' : '' }}">Doctors</a>
                <a href="{{ route('departments.index') }}" class="nav-item {{ request()->is('departments*') ? 'active' : '' }}">Departments</a>
            @endif
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">LOGOUT</button>
        </form>
    </div>

<div class="main">
    <div class="header">
        <div>
            <h1>Daily Schedules</h1>
            <p>Manage doctor availability and booking slots</p>
        </div>
        <button onclick="document.getElementById('scheduleModal').style.display='flex'" class="btn-create">+ Add Schedule</button>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px; margin-bottom: 20px; border-radius: 8px; border-left: 4px solid #27ae60;">
            {{ session('success') }}
        </div>
    @endif

    <div class="content-card">
        <table>
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Available Date</th>
                    <th>Shift</th>
                    <th>Bookings / Capacity</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                <tr>
                    <td style="font-weight: 600;">Dr. {{ $schedule->doctor->FirstName }} {{ $schedule->doctor->LastName }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->AvailableDate)->format('M d, Y (l)') }}</td>
                    <td>
                        @php $shiftClass = strtolower(str_replace(' ', '-', $schedule->Shift)); @endphp
                        <span class="badge badge-{{ $shiftClass }}">{{ $schedule->Shift }}</span>
                    </td>
                    <td>
                        <span style="font-weight: bold; color: {{ $schedule->CurrentBookings >= $schedule->MaxCapacity ? '#e74c3c' : '#27ae60' }}">
                            {{ $schedule->CurrentBookings }}
                        </span> 
                        <span style="color: #999;">/ {{ $schedule->MaxCapacity }}</span>
                    </td>
                    <td style="text-align: right;">
    <form action="{{ route('schedules.destroy', $schedule->ScheduleID) }}" 
          method="POST" 
          onsubmit="return confirm('Are you sure you want to delete the schedule for Dr. {{ $schedule->doctor->LastName }} on {{ \Carbon\Carbon::parse($schedule->AvailableDate)->format('M d') }}? This action cannot be undone.');">
        @csrf 
        @method('DELETE')
        <button type="submit" style="color: #e74c3c; background:none; border:none; cursor:pointer; font-weight: bold; font-family: inherit; font-size: 14px;">
            Delete
        </button>
    </form>
</td>
                @empty
                <tr><td colspan="5" style="text-align: center; padding: 40px; color: #95a5a6;">No schedules registered for the coming days.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="scheduleModal" class="modal-overlay">
    <div class="modal-container">
        <h3 style="margin-top: 0; color: #1a2e1a;">Create Daily Schedule</h3>
        <form action="{{ route('schedules.store') }}" method="POST">
            @csrf
            <label style="font-size: 13px; color: #666;">Assign Doctor</label>
            <select name="DoctorID" class="modal-input" required>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->DoctorID }}">Dr. {{ $doctor->FirstName }} {{ $doctor->LastName }}</option>
                @endforeach
            </select>

            <label style="font-size: 13px; color: #666;">Available Date</label>
            <input type="date" name="AvailableDate" class="modal-input" required min="{{ date('Y-m-d') }}">

            <label style="font-size: 13px; color: #666;">Select Shift</label>
            <select name="Shift" class="modal-input" required>
                <option value="AM">AM (Morning)</option>
                <option value="PM">PM (Afternoon)</option>
                <option value="Full Day">Full Day</option>
            </select>

            <label style="font-size: 13px; color: #666;">Max Patient Capacity</label>
            <input type="number" name="MaxCapacity" class="modal-input" placeholder="e.g. 20" required>

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="submit" style="flex: 2; background: #27ae60; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-weight: bold;">Save Schedule</button>
                <button type="button" onclick="document.getElementById('scheduleModal').style.display='none'" style="flex: 1; background: #eee; border: none; padding: 12px; border-radius: 5px; cursor: pointer;">Cancel</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>