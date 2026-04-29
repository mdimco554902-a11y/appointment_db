<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare Plus | Departments</title>
    <style>
        body { margin: 0; display: flex; font-family: 'Segoe UI', sans-serif; background: #f4f7f6; color: #333; min-height: 100vh; }
        .sidebar { width: 260px; background: #1a2e1a; color: white; height: 100vh; position: fixed; padding: 20px; display: flex; flex-direction: column; box-sizing: border-box; z-index: 100; }
        .sidebar h2 { color: #fff; font-size: 22px; margin-bottom: 5px; }
        .sidebar .role { color: #88a088; font-size: 12px; margin-bottom: 30px; text-transform: uppercase; }
        .nav-menu { flex: 1; }
        .nav-item { padding: 12px 15px; color: #bdc3c7; text-decoration: none; display: block; margin-bottom: 5px; transition: 0.3s; border-radius: 5px; }
        .nav-item:hover, .nav-item.active { background: #2d4d2d; color: white !important; font-weight: bold; }
        .main { margin-left: 260px; padding: 40px; width: calc(100% - 260px); box-sizing: border-box; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .btn-create { background: #27ae60; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold; border: none; cursor: pointer; }
        .content-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #f4f7f6; color: #95a5a6; font-size: 13px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #f4f7f6; font-size: 14px; }
        .btn-logout { background: transparent; border: 1px solid #445544; color: #bdc3c7; padding: 10px; cursor: pointer; width: 100%; margin-top: auto; }
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000; }
        .modal-container { background: white; padding: 30px; border-radius: 10px; width: 400px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .modal-input { width: 100%; padding: 10px; margin: 8px 0 15px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
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
            <a href="{{ route('doctors.index') }}" class="nav-item">Doctors</a>
            <a href="{{ route('departments.index') }}" class="nav-item active">Departments</a>
        </div>
        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn-logout">LOGOUT</button></form>
    </div>

    <div class="main">
        <div class="header">
            <div><h1>Departments</h1><p>Manage hospital units</p></div>
            <button class="btn-create" onclick="document.getElementById('deptModal').style.display='flex'">+ Add Department</button>
        </div>
        <div class="content-card">
            <table>
                <thead>
                    <tr><th>ID</th><th>Department Name</th><th>Description</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                    <tr>
                        <td>#{{ $dept->DeptID }}</td>
                        <td><strong>{{ $dept->DepartmentName }}</strong></td>
                        <td>{{ $dept->Description }}</td>
                        <td>
                            <form action="{{ route('departments.destroy', $dept->DeptID) }}" method="POST" onsubmit="return confirm('Delete department?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="color: #e74c3c; border:none; background:none; cursor:pointer; font-weight:bold;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center; padding: 20px;">No departments added yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="deptModal" class="modal-overlay">
        <div class="modal-container">
            <h3 style="margin-top:0">Add Department</h3>
            <form action="{{ route('departments.store') }}" method="POST">
                @csrf
                <label style="font-size: 13px; color: #666;">Name</label>
                <input type="text" name="DepartmentName" class="modal-input" required placeholder="e.g., Cardiology">
                
                <label style="font-size: 13px; color: #666;">Description</label>
                <input type="text" name="Description" class="modal-input" placeholder="Optional">
                
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" class="btn-create" style="flex: 2">Save</button>
                    <button type="button" onclick="document.getElementById('deptModal').style.display='none'" style="flex: 1; background: #eee; color: #333; border: none; border-radius: 5px; cursor: pointer;">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>