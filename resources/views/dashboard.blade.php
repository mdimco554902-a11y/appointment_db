<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare Plus | Dashboard</title>
    <style>
        /* Main Layout */
        body { margin: 0; display: flex; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; color: #333; }
        
        /* Sidebar Design */
        .sidebar { 
            width: 260px; 
            background: #1a2e1a; /* Dark Medical Green */
            color: white; 
            height: 100vh; 
            position: fixed; 
            padding: 20px;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }
        
        .sidebar h2 { color: #fff; font-size: 22px; margin-bottom: 5px; }
        .sidebar .role { color: #88a088; font-size: 12px; margin-bottom: 30px; text-transform: uppercase; }

        .nav-menu { flex: 1; }
        .nav-item { 
            padding: 12px 15px; 
            color: #bdc3c7; 
            text-decoration: none; 
            display: block; 
            margin-bottom: 5px;
            transition: 0.3s;
            border-radius: 5px;
        }
        
        /* Highlight for the active page */
        .nav-item:hover, .nav-item.active { 
            background: #2d4d2d; 
            color: white !important; 
            font-weight: bold;
        }

        /* Main Content area */
        .main { margin-left: 260px; padding: 40px; width: calc(100% - 260px); }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 28px; }

        /* Stat Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #27ae60; }
        .stat-card h3 { margin: 0; font-size: 14px; color: #7f8c8d; text-transform: uppercase; }
        .stat-card p { margin: 10px 0 0; font-size: 32px; font-weight: bold; color: #2c3e50; }

        /* Table Design */
        .content-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #f4f7f6; color: #95a5a6; font-size: 13px; }
        td { padding: 15px; border-bottom: 1px solid #f4f7f6; font-size: 14px; }
        
        .status-pill { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .status-confirmed { background: #e8f5e9; color: #2e7d32; }
        .status-pending { background: #fff3e0; color: #ef6c00; }

        .btn-create {
            background: #27ae60;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            border: none;
        }

        .btn-logout { 
            background: transparent; 
            border: 1px solid #445544; 
            color: #bdc3c7; 
            padding: 10px; 
            cursor: pointer; 
            width: 100%;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-logout:hover { background: #c0392b; color: white; border-color: #c0392b; }

        /* Modal specific styling */
        .modal-overlay {
            display: none; 
            position: fixed; 
            top: 0; left: 0; 
            width: 100%; height: 100%; 
            background: rgba(0,0,0,0.5); 
            justify-content: center; 
            align-items: center; 
            z-index: 1000;
        }
        .modal-container {
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            width: 400px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .modal-input {
            width: 100%; 
            padding: 10px; 
            margin: 8px 0 15px; 
            border: 1px solid #ddd; 
            border-radius: 5px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>HealthCare Plus</h2>
        <div class="role">Admin Dashboard</div>
        
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('patients.index') }}" class="nav-item {{ request()->routeIs('patients.index') ? 'active' : '' }}">Patient Records</a>
            <a href="#" class="nav-item">Appointments</a>
            <a href="{{ route('doctors.index') }}" class="nav-item {{ request()->routeIs('doctors.index') ? 'active' : '' }}">Doctors</a>
            <a href="{{ route('departments.index') }}" class="nav-item {{ request()->routeIs('departments.index') ? 'active' : '' }}">Departments</a>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">LOGOUT</button>
        </form>
    </div>

    <div class="main">
        <div class="header">
            <div>
                <h1>Welcome, {{ Auth::user()->name }}</h1>
                <p>Brokenshire Medical Center Appointment System</p>
            </div>
            <button onclick="document.getElementById('appointmentModal').style.display='flex'" class="btn-create">+ New Appointment</button>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Patients</h3>
                <p>{{ $totalPatients }}</p>
            </div>
            <div class="stat-card" style="border-left-color: #2980b9;">
                <h3>Total Appointments</h3>
                <p>{{ $totalAppointments }}</p>
            </div>
            <div class="stat-card" style="border-left-color: #f39c12;">
                <h3>Active Doctors</h3>
                <p>{{ $activeDoctors }}</p>
            </div>
        </div>

        <div class="content-card">
            <h3>Recent Appointments</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $app)
                    <tr>
                        <td>#{{ $app->AppointmentID }}</td>
                        <td>
                            @if($app->patient)
                                {{ $app->patient->FirstName }} {{ $app->patient->LastName }}
                            @else
                                <span style="color: #e67e22; font-weight:bold;">ID: {{ $app->PatientID }} (Pending Data)</span>
                            @endif
                        </td>
                        <td>
                            @if($app->doctor)
                                Dr. {{ $app->doctor->LastName }}
                            @else
                                <span style="color: #e67e22; font-weight:bold;">ID: {{ $app->DoctorID }} (Pending Data)</span>
                            @endif
                        </td>
                        <td>{{ $app->AppointmentTime }}</td>
                        <td><span class="status-pill status-{{ strtolower($app->Status ?? 'pending') }}">{{ $app->Status ?? 'Pending' }}</span></td>
                        <td>
                            <form action="{{ route('appointments.destroy', $app->AppointmentID) }}" method="POST" onsubmit="return confirm('Cancel this appointment?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="color: #e74c3c; background:none; border:none; cursor:pointer;">Cancel</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding: 30px; color: #95a5a6;">No appointments found in the system.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="appointmentModal" class="modal-overlay">
        <div class="modal-container">
            <h3 style="margin-top: 0;">Add New Appointment</h3>
            
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="Status" value="Pending">

                <label style="font-size: 13px; color: #666;">Patient ID</label>
                <input type="number" name="PatientID" placeholder="e.g. 1" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Doctor ID</label>
                <input type="number" name="DoctorID" placeholder="e.g. 1" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Schedule ID</label>
                <input type="number" name="ScheduleID" placeholder="e.g. 1" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Appointment Time</label>
                <input type="time" name="AppointmentTime" required class="modal-input">
                
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" style="flex: 2; background: #27ae60; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-weight: bold;">Save</button>
                    <button type="button" onclick="document.getElementById('appointmentModal').style.display='none'" style="flex: 1; background: #eee; border: none; padding: 12px; border-radius: 5px; cursor: pointer;">Close</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>