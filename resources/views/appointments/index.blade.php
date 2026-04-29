<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare Plus | Appointments</title>
    <style>
        /* Main Layout */
        body { margin: 0; display: flex; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; color: #333; }
        
        /* Sidebar Design */
        .sidebar { 
            width: 260px; 
            background: #1a2e1a; 
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
        .nav-item:hover, .nav-item.active { 
            background: #2d4d2d; 
            color: white !important; 
            font-weight: bold;
        }

        /* Main Content */
        .main { margin-left: 260px; padding: 40px; width: calc(100% - 260px); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 28px; }

        /* Table & Cards */
        .content-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #f4f7f6; color: #95a5a6; font-size: 13px; }
        td { padding: 15px; border-bottom: 1px solid #f4f7f6; font-size: 14px; }
        
        /* STATUS PILL COLORS (Matches Dashboard) */
        .status-pill { 
            padding: 5px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: bold; 
            text-transform: capitalize; 
            display: inline-block;
        }
        .status-confirmed { background: #e8f5e9; color: #2e7d32; }
        .status-pending { background: #fff3e0; color: #ef6c00; }
        .status-completed { background: #e3f2fd; color: #1976d2; }
        .status-cancelled { background: #ffebee; color: #c62828; }

        .btn-create {
            background: #27ae60;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .btn-edit-action { color: #3498db; background:none; border:none; cursor:pointer; font-weight: bold; margin-right: 10px; }
        .btn-edit-action:hover { text-decoration: underline; }

        .btn-logout { 
            background: transparent; 
            border: 1px solid #445544; 
            color: #bdc3c7; 
            padding: 10px; 
            cursor: pointer; 
            width: 100%;
            margin-top: 20px;
        }

        /* Modals */
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
            <a href="{{ route('appointments.index') }}" class="nav-item {{ request()->routeIs('appointments.index') ? 'active' : '' }}">Appointments</a>
            <a href="{{ route('doctors.index') }}" class="nav-item">Doctors</a>
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
                <h1>Appointments</h1>
                <p>Manage and track patient visit schedules</p>
            </div>
            <button onclick="document.getElementById('appointmentModal').style.display='flex'" class="btn-create">+ New Appointment</button>
        </div>

        <div class="content-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $app)
                    <tr>
                        <td>#{{ $app->AppointmentID }}</td>
                        <td>{{ $app->patient->FirstName ?? 'Unknown' }} {{ $app->patient->LastName ?? '' }}</td>
                        <td>Dr. {{ $app->doctor->LastName ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($app->AppointmentTime)->format('M d, Y h:i A') }}</td>
                        <td>
                            <span class="status-pill status-{{ strtolower($app->Status ?? 'pending') }}">
                                {{ strtolower($app->Status ?? 'pending') }}
                            </span>
                        </td>
                        <td style="display: flex; align-items: center;">
                            <button class="btn-edit-action" onclick="openEditModal('{{ $app->AppointmentID }}', '{{ $app->AppointmentTime }}', '{{ $app->Status }}')">Edit</button>

                            <form action="{{ route('appointments.destroy', $app->AppointmentID) }}" method="POST" onsubmit="return confirm('Delete this record permanently?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="color: #e74c3c; border:none; background:none; cursor:pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center; padding: 20px; color: #95a5a6;">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="appointmentModal" class="modal-overlay">
        <div class="modal-container">
            <h3>Schedule New Appointment</h3>
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <label style="font-size: 13px; color: #666;">Select Patient</label>
                <select name="PatientID" class="modal-input" required>
                    @foreach($patients as $p)
                        <option value="{{ $p->PatientID }}">{{ $p->FirstName }} {{ $p->LastName }}</option>
                    @endforeach
                </select>
                <label style="font-size: 13px; color: #666;">Select Doctor</label>
                <select name="DoctorID" class="modal-input" required>
                    @foreach($doctors as $d)
                        <option value="{{ $d->DoctorID }}">Dr. {{ $d->LastName }}</option>
                    @endforeach
                </select>
                <label style="font-size: 13px; color: #666;">Date & Time</label>
                <input type="datetime-local" name="AppointmentTime" class="modal-input" required>
                <button type="submit" class="btn-create" style="width:100%">Create</button>
                <button type="button" onclick="document.getElementById('appointmentModal').style.display='none'" style="width:100%; border:none; margin-top:10px; cursor:pointer; background:#eee; padding:10px; border-radius:5px;">Cancel</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="modal-overlay">
        <div class="modal-container">
            <h3>Update Appointment</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <label style="font-size: 13px; color: #666;">Date & Time</label>
                <input type="datetime-local" name="AppointmentTime" id="editTime" required class="modal-input">
                <label style="font-size: 13px; color: #666;">Status</label>
                <select name="Status" id="editStatus" class="modal-input">
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                <button type="submit" class="btn-create" style="width:100%; background: #3498db;">Update</button>
                <button type="button" onclick="document.getElementById('editModal').style.display='none'" style="width:100%; border:none; margin-top:10px; cursor:pointer; background:#eee; padding:10px; border-radius:5px;">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, time, status) {
            const form = document.getElementById('editForm');
            form.action = `/appointments/${id}`;
            
            // Format time for datetime-local input
            let formattedTime = time.replace(" ", "T").substring(0, 16);
            document.getElementById('editTime').value = formattedTime;
            
            document.getElementById('editStatus').value = status || 'Pending';
            document.getElementById('editModal').style.display = 'flex';
        }
    </script>
</body>
</html>