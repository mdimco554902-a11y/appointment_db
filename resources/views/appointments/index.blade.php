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
        .content-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; min-width: 900px; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #f4f7f6; color: #95a5a6; font-size: 13px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #f4f7f6; font-size: 14px; }
        
        /* Priority Badge */
        .priority-badge { background: #1a2e1a; color: white; padding: 4px 10px; border-radius: 5px; font-weight: bold; font-size: 12px; }

        /* STATUS PILL COLORS */
        .status-pill { 
            padding: 5px 12px; 
            border-radius: 20px; 
            font-size: 11px; 
            font-weight: bold; 
            text-transform: uppercase; 
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

        /* Cancel button for customers */
        .btn-cancel-action { color: #e67e22; background:none; border:none; cursor:pointer; font-weight: bold; }
        .btn-cancel-action:hover { text-decoration: underline; }

        .btn-logout { 
            background: transparent; 
            border: 1px solid #445544; 
            color: #bdc3c7; 
            padding: 10px; 
            cursor: pointer; 
            width: 100%;
            margin-top: 20px;
            border-radius: 5px;
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
            width: 550px; 
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-input {
            width: 100%; 
            padding: 10px; 
            margin: 8px 0 15px; 
            border: 1px solid #ddd; 
            border-radius: 5px;
            box-sizing: border-box;
            font-family: inherit;
        }

        /* Error Alert Style */
        .alert-error {
            background: #fee2e2; 
            color: #b91c1c; 
            padding: 15px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            border-left: 5px solid #ef4444;
        }
    </style>
</head>
<body>

    <div class="sidebar">
    <h2>HealthCare Plus</h2>
    <div class="role">{{ auth()->user()->isAdmin() ? 'Manage Appointments' : 'Patient Portal' }}</div>
    
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
                <h1>Appointments</h1>
                <p>Manage and track patient visit schedules & priority numbers</p>
            </div>
            <button onclick="document.getElementById('appointmentModal').style.display='flex'" class="btn-create">+ New Appointment</button>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <strong>Submission Error:</strong>
                <ul style="margin-top: 5px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #27ae60;">
                {{ session('success') }}
            </div>
        @endif

        <div class="content-card">
            <table>
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Service</th>
                        <th>Date & Shift</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $app)
                    <tr>
                        <td><span class="priority-badge">#{{ str_pad($app->PriorityNumber, 3, '0', STR_PAD_LEFT) }}</span></td>
                        <td style="font-weight: 600;">{{ $app->patient->FirstName ?? 'Unknown' }} {{ $app->patient->LastName ?? '' }}</td>
                        <td>Dr. {{ $app->doctor->LastName ?? 'N/A' }}</td>
                        <td><span style="color: #27ae60; font-weight: 500;">{{ $app->service->ServiceName ?? 'General' }}</span></td>
                        <td>
                            <div style="font-weight: 500;">
                                {{ $app->dailySchedule ? \Carbon\Carbon::parse($app->dailySchedule->AvailableDate)->format('M d, Y') : 'N/A' }}
                            </div>
                            <div style="font-size: 11px; color: #7f8c8d;">{{ $app->Shift }}</div>
                        </td>
                        <td>
                            <span class="status-pill status-{{ strtolower($app->Status ?? 'pending') }}">
                                {{ $app->Status ?? 'pending' }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                @if(auth()->user()->isAdmin())
                                    <button class="btn-edit-action" onclick="openEditModal('{{ $app->AppointmentID }}', '{{ $app->AppointmentTime }}', '{{ $app->Status }}')">Edit</button>

                                    <form action="{{ route('appointments.destroy', $app->AppointmentID) }}" method="POST" onsubmit="return confirm('Delete this record permanently?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="color: #e74c3c; border:none; background:none; cursor:pointer; font-weight: bold;">Delete</button>
                                    </form>
                                @else
                                    @php $statusLower = strtolower($app->Status ?? 'pending'); @endphp
                                    @if($statusLower === 'pending')
                                        <form action="{{ route('appointments.update', $app->AppointmentID) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="Status" value="Cancelled">
                                            <button type="submit" class="btn-cancel-action">Cancel Booking</button>
                                        </form>
                                    @else
                                        <span style="color: #95a5a6; font-size: 12px; font-weight: bold;">Locked</span>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center; padding: 40px; color: #95a5a6;">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="appointmentModal" class="modal-overlay">
    <div class="modal-container">
        <h3 style="margin-top:0;">Book an Appointment</h3>
        
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            
            <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
                <p style="font-size: 12px; font-weight: bold; margin: 0 0 10px 0; color: #1a2e1a; text-transform: uppercase;">1. Personal Information</p>
                
                <div style="display: flex; gap: 10px;">
                    <input type="text" name="FirstName" placeholder="First Name" class="modal-input" required style="flex:1;">
                    <input type="text" name="MiddleName" placeholder="Middle Name" class="modal-input" style="flex:1;">
                    <input type="text" name="LastName" placeholder="Last Name" class="modal-input" required style="flex:1;">
                </div>

                <div style="display: flex; gap: 10px;">
                    <input type="email" name="Email" placeholder="Email Address" class="modal-input" required>
                    <input type="text" name="Phone" placeholder="Phone Number" class="modal-input" required>
                </div>

                <div style="display: flex; gap: 10px; align-items: center;">
                    <div style="flex: 1;">
                        <label style="font-size: 11px;">Gender</label>
                        <select name="Gender" class="modal-input" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label style="font-size: 11px;">Age</label>
                        <input type="number" name="Age" class="modal-input" required>
                    </div>
                    <div style="flex: 2;">
                        <label style="font-size: 11px;">Birth Date</label>
                        <input type="date" name="BirthDate" class="modal-input" required>
                    </div>
                </div>
            </div>

            <p style="font-size: 12px; font-weight: bold; margin: 0 0 10px 0; color: #1a2e1a; text-transform: uppercase;">2. Visit Details</p>

            <label style="font-size: 13px; color: #666;">Select Available Date & Doctor</label>
            <select name="ScheduleID" class="modal-input" required>
                <option value="" disabled selected>-- Choose Schedule Slot --</option>
                @foreach($schedules as $s)
                    <option value="{{ $s->ScheduleID }}">
                        {{ \Carbon\Carbon::parse($s->AvailableDate)->format('M d, Y') }} - Dr. {{ $s->doctor->LastName }} ({{ $s->Shift }})
                    </option>
                @endforeach
            </select>

            <label style="font-size: 13px; color: #666;">Select Medical Service</label>
            <select name="ServiceID" class="modal-input" required>
                <option value="" disabled selected>-- Choose Service --</option>
                @foreach($services as $svc)
                    <option value="{{ $svc->ServiceID }}">{{ $svc->ServiceName }}</option>
                @endforeach
            </select>

            <label style="font-size: 13px; color: #666;">Reason for Visit (Optional)</label>
            <textarea name="BookingReason" class="modal-input" style="height: 60px; resize: none;" placeholder="Briefly describe your concern..."></textarea>

            <button type="submit" class="btn-create" style="width:100%">Confirm Appointment</button>
            <button type="button" onclick="document.getElementById('appointmentModal').style.display='none'" style="width:100%; border:none; margin-top:10px; cursor:pointer; background:#eee; padding:12px; border-radius:5px;">Cancel</button>
        </form>
    </div>
</div>

    <div id="editModal" class="modal-overlay">
        <div class="modal-container">
            <h3 style="margin-top:0;">Update Appointment Status</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                
                <label style="font-size: 13px; color: #666;">Update Time</label>
                <input type="time" name="AppointmentTime" id="editTime" class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Current Status</label>
                <select name="Status" id="editStatus" class="modal-input">
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>

                <div style="margin-top: 10px;">
                    <button type="submit" class="btn-create" style="width:100%; background: #3498db;">Update Appointment</button>
                    <button type="button" onclick="document.getElementById('editModal').style.display='none'" style="width:100%; border:none; margin-top:10px; cursor:pointer; background:#eee; padding:12px; border-radius:5px;">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, time, status) {
            const form = document.getElementById('editForm');
            form.action = `/appointments/${id}`;
            
            if(time) {
                document.getElementById('editTime').value = time;
            }
            
            document.getElementById('editStatus').value = status || 'Pending';
            document.getElementById('editModal').style.display = 'flex';
        }

        window.onclick = function(event) {
            if (event.target.className === 'modal-overlay') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>