<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare Plus | Medical Services</title>
    <style>
        /* Main Layout - Matched to Patient Records */
        body { margin: 0; display: flex; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; color: #333; }
        
        /* Sidebar Design - Matched Theme */
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
        
        .nav-item:hover, .nav-item.active { background: #2d4d2d; color: white !important; border-radius: 5px; font-weight: bold; }

        /* Main Content area */
        .main { margin-left: 260px; padding: 40px; width: calc(100% - 260px); }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 28px; }
        .header p { margin: 5px 0 0; color: #666; }

        /* Search Bar Styling - Matched to Patient Records */
        .search-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            background: white;
            padding: 10px 15px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
        }
        .search-icon {
            width: 18px;
            height: 18px;
            color: #95a5a5;
            display: flex;
            align-items: center;
        }
        .search-input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
            margin-left: 12px;
            background: transparent;
        }

        /* Table/Card Design */
        .content-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #f4f7f6; color: #95a5a6; font-size: 13px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #f4f7f6; font-size: 14px; }
        
        .dept-badge {
            background: #eef7ee;
            color: #27ae60;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

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
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-logout:hover { background: #c0392b; color: white; border-color: #c0392b; }

        /* Modal Overlay - Matched to Patient Records */
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
            width: 450px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
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
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>HealthCare Plus</h2>
        <div class="role">{{ auth()->user()->isAdmin() ? 'Services' : 'Patient Portal' }}</div>
        
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-item">Dashboard</a>
            
            @if(auth()->user()->isAdmin())
                <a href="{{ route('services.index') }}" class="nav-item active">Medical Services</a>
                <a href="{{ route('schedules.index') }}" class="nav-item">Daily Schedules</a>
                <a href="{{ route('patients.index') }}" class="nav-item">Patient Records</a>
            @endif

            <a href="{{ route('appointments.index') }}" class="nav-item">Appointments</a>

            @if(auth()->user()->isAdmin())
                <a href="{{ route('doctors.index') }}" class="nav-item">Doctors</a>
                <a href="{{ route('departments.index') }}" class="nav-item">Departments</a>
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
                <h1>Medical Services</h1>
                <p>Manage the clinical services offered by each department</p>
            </div>
            <button onclick="document.getElementById('serviceModal').style.display='flex'" class="btn-create">+ Add New Service</button>
        </div>

        <div class="search-container">
            <div class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <input type="text" id="serviceSearchInput" class="search-input" placeholder="Search by Service Name or Department..." onkeyup="filterServiceTable()">
        </div>

        <div class="content-card">
            <table id="serviceTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Department</th>
                        <th>Description</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr class="service-row">
                        <td class="service-id" style="color: #95a5a6;">#{{ $service->ServiceID }}</td>
                        <td class="service-name" style="font-weight: bold;">{{ $service->ServiceName }}</td>
                        <td class="service-dept">
                            <span class="dept-badge">{{ $service->department->DepartmentName ?? 'General' }}</span>
                        </td>
                        <td style="color: #666; max-width: 300px;">{{ $service->Description ?? 'No description provided.' }}</td>
                        <td style="text-align: right;">
                            <form action="{{ route('services.destroy', $service->ServiceID) }}" method="POST" onsubmit="return confirm('Delete this service?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="color: #e74c3c; background:none; border:none; cursor:pointer; font-weight: bold; font-family: inherit; font-size: 14px;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 30px; color: #95a5a6;">No medical services registered yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="serviceModal" class="modal-overlay">
        <div class="modal-container">
            <h3 style="margin-top: 0; color: #1a2e1a;">Add New Medical Service</h3>
            <form action="{{ route('services.store') }}" method="POST">
                @csrf
                <label style="font-size: 13px; color: #666; font-weight: bold;">Service Name</label>
                <input type="text" name="ServiceName" placeholder="e.g., General Checkup" required class="modal-input">
                
                <label style="font-size: 13px; color: #666; font-weight: bold;">Department</label>
                <select name="DeptID" required class="modal-input" style="height: 40px;">
                    <option value="" disabled selected>Select Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->DeptID }}">{{ $dept->DepartmentName }}</option>
                    @endforeach
                </select>
                
                <label style="font-size: 13px; color: #666; font-weight: bold;">Description (Optional)</label>
                <textarea name="Description" placeholder="Describe the service..." class="modal-input" style="height: 80px;"></textarea>

                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" style="flex: 2; background: #27ae60; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-weight: bold;">Save Service</button>
                    <button type="button" onclick="document.getElementById('serviceModal').style.display='none'" style="flex: 1; background: #eee; border: none; padding: 12px; border-radius: 5px; cursor: pointer; color: #333;">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Matching search logic from patient index
        function filterServiceTable() {
            const input = document.getElementById('serviceSearchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('serviceTable');
            const rows = table.getElementsByClassName('service-row');

            for (let i = 0; i < rows.length; i++) {
                const nameCell = rows[i].getElementsByClassName('service-name')[0].textContent.toLowerCase();
                const deptCell = rows[i].getElementsByClassName('service-dept')[0].textContent.toLowerCase();

                if (nameCell.includes(filter) || deptCell.includes(filter)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('serviceModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>