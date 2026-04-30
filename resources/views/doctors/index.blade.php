<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare Plus | Doctors</title>
    <style>
        /* Sidebar and Layout */
        body { margin: 0; display: flex; font-family: 'Segoe UI', sans-serif; background: #f4f7f6; color: #333; }
        .sidebar { width: 260px; background: #1a2e1a; color: white; height: 100vh; position: fixed; padding: 20px; display: flex; flex-direction: column; box-sizing: border-box; }
        .sidebar h2 { color: #fff; font-size: 22px; margin-bottom: 5px; }
        .sidebar .role { color: #88a088; font-size: 12px; margin-bottom: 30px; text-transform: uppercase; }
        
        .nav-menu { flex: 1; }
        .nav-item { padding: 12px 15px; color: #bdc3c7; text-decoration: none; display: block; margin-bottom: 5px; transition: 0.3s; border-radius: 5px; }
        .nav-item:hover, .nav-item.active { background: #2d4d2d; color: white !important; font-weight: bold; }

        /* Content Area */
        .main { margin-left: 260px; padding: 40px; width: calc(100% - 260px); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .btn-create { background: #27ae60; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold; border: none; cursor: pointer; }

        /* Table Design */
        .content-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #f4f7f6; color: #95a5a6; font-size: 13px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #f4f7f6; font-size: 14px; }
        
        /* Blue Specialty Badge */
        .badge-blue { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: capitalize; background: #e3f2fd; color: #1976d2; display: inline-block; }

        .btn-logout { background: transparent; border: 1px solid #445544; color: #bdc3c7; padding: 10px; cursor: pointer; width: 100%; margin-top: auto; }

        /* Modal Specific Styling */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000;
        }
        .modal-container { background: white; padding: 30px; border-radius: 10px; width: 450px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .modal-input { width: 100%; padding: 10px; margin: 8px 0 15px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        
        /* Alert Styling */
        .alert-success { background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #bbf7d0; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>HealthCare Plus</h2>
        <div class="role">Admin Dashboard</div>
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-item">Dashboard</a>
            <a href="{{ route('patients.index') }}" class="nav-item">Patient Records</a>
            <a href="{{ route('appointments.index') }}" class="nav-item">Appointments</a>
            <a href="{{ route('doctors.index') }}" class="nav-item active">Doctors</a>
            <a href="{{ route('departments.index') }}" class="nav-item">Departments</a>
        </div>
        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn-logout">LOGOUT</button></form>
    </div>

    <div class="main">
        <div class="header">
            <div>
                @if (session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fecaca;">
                        <ul style="margin:0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h1>Doctors Directory</h1>
                <p>Manage medical professional staff</p>
            </div>
            <button class="btn-create" onclick="document.getElementById('addDoctorModal').style.display='flex'">+ Add Doctor</button>
        </div>

        <div class="content-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doc)
                    <tr>
                        <td>#{{ $doc->DoctorID }}</td>
                        <td>
                            <strong>
                                Dr. {{ $doc->FirstName }} {{ $doc->MiddleName ? $doc->MiddleName . ' ' : '' }}{{ $doc->LastName }}
                            </strong>
                        </td>
                        <td>{{ $doc->Specialization }}</td>
                        <td><span class="badge-blue">{{ $doc->department->DepartmentName ?? 'General' }}</span></td>
                        <td style="display: flex; align-items: center;">
                            <button onclick="openEditModal({{ json_encode($doc) }})" style="color: #3498db; background:none; border:none; cursor:pointer; font-weight:bold; margin-right: 15px;">Edit</button>
                            
                            <form action="{{ route('doctors.destroy', $doc->DoctorID) }}" method="POST" onsubmit="return confirm('Remove this doctor?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="color: #e74c3c; border:none; background:none; cursor:pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center; padding: 20px;">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="addDoctorModal" class="modal-overlay">
        <div class="modal-container">
            <h3 style="margin-top:0; color: #2c3e50; border-bottom: 1px solid #eee; padding-bottom: 10px;">Register New Doctor</h3>
            <form action="{{ route('doctors.store') }}" method="POST">
                @csrf
                <label style="font-size: 13px; color: #666;">First Name</label>
                <input type="text" name="FirstName" class="modal-input" required placeholder="Ex: Gregory">
                
                <label style="font-size: 13px; color: #666;">Middle Name</label>
                <input type="text" name="MiddleName" class="modal-input" placeholder="Optional">
                
                <label style="font-size: 13px; color: #666;">Last Name</label>
                <input type="text" name="LastName" class="modal-input" required placeholder="Ex: House">

                <label style="font-size: 13px; color: #666;">Specialization</label>
                <input type="text" name="Specialization" class="modal-input" required placeholder="Ex: Diagnostic Medicine">

                <label style="font-size: 13px; color: #666;">Department</label>
                <select name="DeptID" class="modal-input" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->DeptID }}">{{ $dept->DepartmentName }}</option>
                    @endforeach
                </select>

                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" class="btn-create" style="flex: 2">Save Doctor</button>
                    <button type="button" onclick="closeModal()" style="flex: 1; background: #eee; color: #333; border: none; border-radius: 5px; cursor: pointer;">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editDoctorModal" class="modal-overlay">
        <div class="modal-container">
            <h3 style="margin-top:0">Edit Doctor Profile</h3>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                
                <label style="font-size: 13px; color: #666;">First Name</label>
                <input type="text" name="FirstName" id="edit_firstname" class="modal-input" required>
                
                <label style="font-size: 13px; color: #666;">Middle Name</label>
                <input type="text" name="MiddleName" id="edit_middlename" class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Last Name</label>
                <input type="text" name="LastName" id="edit_lastname" class="modal-input" required>

                <label style="font-size: 13px; color: #666;">Specialization</label>
                <input type="text" name="Specialization" id="edit_spec" class="modal-input" required>

                <label style="font-size: 13px; color: #666;">Department</label>
                <select name="DeptID" id="edit_dept" class="modal-input" required>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->DeptID }}">{{ $dept->DepartmentName }}</option>
                    @endforeach
                </select>

                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" class="btn-create" style="flex: 2; background: #3498db;">Update Profile</button>
                    <button type="button" onclick="closeModal()" style="flex: 1; background: #eee; color: #333; border: none; border-radius: 5px; cursor: pointer;">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openEditModal(doc) {
        const form = document.getElementById('editForm');
        form.action = `/doctors/${doc.DoctorID}`;

        // Fixed IDs to match HTML: edit_firstname, edit_middlename, edit_lastname
        document.getElementById('edit_firstname').value = doc.FirstName;
        document.getElementById('edit_middlename').value = doc.MiddleName || ''; 
        document.getElementById('edit_lastname').value = doc.LastName;
        document.getElementById('edit_spec').value = doc.Specialization;
        document.getElementById('edit_dept').value = doc.DeptID;

        document.getElementById('editDoctorModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('addDoctorModal').style.display = 'none';
        document.getElementById('editDoctorModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const addModal = document.getElementById('addDoctorModal');
        const editModal = document.getElementById('editDoctorModal');
        if (event.target == addModal || event.target == editModal) {
            closeModal();
        }
    }
    </script>
</body>
</html>