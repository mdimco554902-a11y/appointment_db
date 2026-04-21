<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare Plus | Patient Records</title>
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
        .nav-item:hover, .nav-item.active { background: #2d4d2d; color: white; border-radius: 5px; }

        /* Main Content area */
        .main { margin-left: 260px; padding: 40px; width: calc(100% - 260px); }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 28px; }

        /* Table/Card Design */
        .content-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #f4f7f6; color: #95a5a6; font-size: 13px; }
        td { padding: 15px; border-bottom: 1px solid #f4f7f6; font-size: 14px; }
        
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
            <a href="{{ route('doctors.index') }}" class="nav-item">Doctors</a>
            <a href="{{ route('departments.index') }}" class="nav-item">Departments</a>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">LOGOUT</button>
        </form>
    </div>

    <div class="main">
        <div class="header">
            <div>
                <h1>Patient Records</h1>
                <p>Manage and view all registered patients</p>
            </div>
            <button onclick="document.getElementById('patientModal').style.display='flex'" class="btn-create">+ Add Patient</button>
        </div>

        <div class="content-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td>#{{ $patient->PatientID }}</td>
                        <td>{{ $patient->FirstName }} {{ $patient->LastName }}</td>
                        <td>{{ $patient->Email }}</td>
                        <td>{{ $patient->Phone ?? 'N/A' }}</td>
                        <td>
                            <form action="{{ route('patients.destroy', $patient->PatientID) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="color: #e74c3c; background:none; border:none; cursor:pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 30px; color: #95a5a6;">No patients recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="patientModal" class="modal-overlay">
        <div class="modal-container">
            <h3 style="margin-top: 0;">Add New Patient</h3>
            
            <form action="{{ route('patients.store') }}" method="POST">
                @csrf
                <label style="font-size: 13px; color: #666;">First Name</label>
                <input type="text" name="FirstName" placeholder="Enter first name" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Last Name</label>
                <input type="text" name="LastName" placeholder="Enter last name" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Email Address</label>
                <input type="email" name="Email" placeholder="e.g. patient@example.com" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Phone Number</label>
                <input type="text" name="Phone" placeholder="e.g. 09123456789" class="modal-input">
                
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" style="flex: 2; background: #27ae60; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-weight: bold;">Save Patient</button>
                    <button type="button" onclick="document.getElementById('patientModal').style.display='none'" style="flex: 1; background: #eee; border: none; padding: 12px; border-radius: 5px; cursor: pointer;">Cancel</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>