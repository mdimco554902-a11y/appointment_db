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
        
        .nav-item:hover, .nav-item.active { background: #2d4d2d; color: white !important; border-radius: 5px; font-weight: bold; }

        /* Main Content area */
        .main { margin-left: 260px; padding: 40px; width: calc(100% - 260px); }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 28px; color: #1a2e1a; }
        .header p { color: #666; margin-top: 5px; }

        /* Search Bar Styling */
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
            color: #95a5a6;
            display: flex;
            align-items: center;
            justify-content: center;
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
            width: 450px; 
            max-height: 90vh;
            overflow-y: auto;
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

        /* --- PROFESSIONAL VIEW DETAILS STYLING --- */
        .profile-container { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 25px; font-size: 14px; }
        .detail-group { display: flex; flex-direction: column; }
        .detail-label { font-weight: bold; color: #1a2e1a; margin-bottom: 2px; font-size: 13px; }
        .detail-value { color: #555; padding: 8px 12px; background: #fbfdfc; border: 1px solid #edf2ef; border-radius: 6px; }
        .detail-value-special { color: #27ae60; font-weight: bold; font-size: 16px; }
        #viewBirthDate { color: #1a2e1a; font-weight: 500; }

        /* --- NEW PATIENT BOOKING FORM STYLING --- */
        .booking-wrapper { max-width: 850px; margin: 0 auto; }
        .booking-card { border-top: 5px solid #27ae60; padding: 35px; }
        .section-title { font-size: 18px; color: #1a2e1a; margin-bottom: 20px; border-bottom: 2px solid #edf2ef; padding-bottom: 8px; margin-top: 25px; font-weight: 600; }
        .section-title:first-child { margin-top: 0; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-size: 13px; color: #555; font-weight: 600; margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea { padding: 12px; border: 1px solid #dcdcdc; border-radius: 6px; font-size: 14px; transition: all 0.3s ease; font-family: inherit; background: #fdfdfd; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #27ae60; outline: none; box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.15); background: #fff; }
        .form-group.full-width { grid-column: span 2; }
        .btn-submit { background: #27ae60; color: white; border: none; padding: 16px; font-size: 16px; font-weight: bold; border-radius: 8px; cursor: pointer; transition: 0.3s; margin-top: 30px; width: 100%; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 6px rgba(39,174,96,0.2); }
        .btn-submit:hover { background: #219653; transform: translateY(-2px); box-shadow: 0 6px 12px rgba(39,174,96,0.3); }

    </style>
</head>
<body>

    <div class="sidebar">
        <h2>HealthCare Plus</h2>
        <div class="role">{{ auth()->user()->isAdmin() ? 'Manage Patients' : 'Patient Portal' }}</div>
        
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
        @if(Auth::user()->email == 'admin@gmail.com')
            <div class="header">
                <div>
                    <h1>Patient Records</h1>
                    <p>Manage and view all registered patients</p>
                </div>
                <button onclick="document.getElementById('patientModal').style.display='flex'" class="btn-create">+ Add Patient</button>
            </div>

            <div class="search-container">
                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
                <input type="text" id="patientSearchInput" class="search-input" placeholder="Search by ID, Name, or Email..." onkeyup="filterPatientTable()">
            </div>

            <div class="content-card">
                <table id="patientTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age</th> <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                        <tr class="patient-row">
                            <td class="patient-id">#{{ $patient->PatientID }}</td>
                            <td class="patient-name">
                                {{ $patient->FirstName }} 
                                {{ $patient->MiddleName ? $patient->MiddleName . ' ' : '' }}{{ $patient->LastName }}
                            </td>
                            <td>{{ $patient->Age ?? 'N/A' }}</td> <td class="patient-email">{{ $patient->Email }}</td>
                            <td>{{ $patient->Phone ?? 'N/A' }}</td>
                            <td style="display: flex; gap: 15px; align-items: center;">
                                <a href="javascript:void(0)" 
                                   onclick="viewPatientDetails({{ json_encode($patient) }})" 
                                   style="color: #3498db; text-decoration: none; font-weight: bold; cursor:pointer;">
                                   View
                                </a>

                                <a href="javascript:void(0)" 
                                   onclick="openEditModal({{ json_encode($patient) }})" 
                                   style="color: #f39c12; text-decoration: none; font-weight: bold; cursor:pointer;">
                                   Edit
                                </a>
                                
                                <form action="{{ route('patients.destroy', $patient->PatientID) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="color: #e74c3c; background:none; border:none; cursor:pointer; font-weight: bold; font-family: inherit; font-size: 14px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr id="noResultsRow">
                            <td colspan="6" style="text-align:center; padding: 30px; color: #95a5a6;">No patients recorded yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <div class="booking-wrapper">
                <div class="header">
                    <div>
                        <h1>Book an Appointment</h1>
                        <p>Fill out your details to schedule a visit. Your information will be saved to your patient record.</p>
                    </div>
                </div>

                <div class="content-card booking-card">
                    <form action="{{ route('appointments.store') }}" method="POST">
                        @csrf
                        
                        <div class="section-title">Personal Information</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>First Name <span style="color:red;">*</span></label>
                                <input type="text" name="FirstName" placeholder="Enter first name" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name <span style="color:red;">*</span></label>
                                <input type="text" name="LastName" placeholder="Enter last name" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="Email" value="{{ auth()->user()->email }}" readonly style="background: #edf2ef; cursor: not-allowed;">
                            </div>
                            <div class="form-group">
                                <label>Phone Number <span style="color:red;">*</span></label>
                                <input type="text" name="Phone" placeholder="e.g. 09123456789" required>
                            </div>
                            <div class="form-group">
                                <label>Age <span style="color:red;">*</span></label>
                                <input type="number" name="Age" placeholder="e.g. 25" required>
                            </div>
                            <div class="form-group">
                                <label>Gender <span style="color:red;">*</span></label>
                                <select name="Gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Blood Type (Optional)</label>
                                <select name="BloodType">
                                    <option value="">Select Type</option>
                                    <option value="A+">A+</option><option value="A-">A-</option>
                                    <option value="B+">B+</option><option value="B-">B-</option>
                                    <option value="O+">O+</option><option value="O-">O-</option>
                                    <option value="AB+">AB+</option><option value="AB-">AB-</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Birth Date (Optional)</label>
                                <input type="date" name="BirthDate">
                            </div>
                        </div>

                        <div class="section-title">Appointment Details</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Preferred Date <span style="color:red;">*</span></label>
                                <input type="date" name="AppointmentDate" required>
                            </div>
                            <div class="form-group">
                                <label>Preferred Time (Shift) <span style="color:red;">*</span></label>
                                <select name="Shift" required>
                                    <option value="">Select Shift</option>
                                    <option value="AM">Morning (AM)</option>
                                    <option value="PM">Afternoon (PM)</option>
                                </select>
                            </div>
                            <div class="form-group full-width">
                                <label>Reason for Booking / Symptoms <span style="color:red;">*</span></label>
                                <textarea name="Reason" rows="4" placeholder="Please describe your symptoms or reason for visiting..." required></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit">Confirm Booking</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <div id="patientModal" class="modal-overlay">
        <div class="modal-container">
            <h3 style="margin-top: 0; color: #1a2e1a;">Add New Patient</h3>
            <form action="{{ route('patients.store') }}" method="POST">
                @csrf
                <label style="font-size: 13px; color: #666;">First Name</label>
                <input type="text" name="FirstName" placeholder="Enter first name" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Middle Name</label>
                <input type="text" name="MiddleName" placeholder="Enter middle name" class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Last Name</label>
                <input type="text" name="LastName" placeholder="Enter last name" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Email Address</label>
                <input type="email" name="Email" placeholder="e.g. patient@example.com" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Phone Number</label>
                <input type="text" name="Phone" placeholder="e.g. 09123456789" class="modal-input">

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label style="font-size: 13px; color: #666;">Age</label> <input type="number" name="Age" placeholder="e.g. 25" class="modal-input">
                    </div>
                    <div style="flex: 1;">
                        <label style="font-size: 13px; color: #666;">Gender</label>
                        <select name="Gender" class="modal-input" style="height: 40px;">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label style="font-size: 13px; color: #666;">Birth Date</label>
                        <input type="date" name="BirthDate" class="modal-input">
                    </div>
                    <div style="flex: 1;">
                        <label style="font-size: 13px; color: #666;">Blood Type</label>
                        <select name="BloodType" class="modal-input" style="height: 40px;">
                            <option value="">Select</option>
                            <option value="A+">A+</option><option value="A-">A-</option>
                            <option value="B+">B+</option><option value="B-">B-</option>
                            <option value="O+">O+</option><option value="O-">O-</option>
                            <option value="AB+">AB+</option><option value="AB-">AB-</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label style="font-size: 13px; color: #666;">Height (cm)</label>
                        <input type="number" step="0.01" name="Height" placeholder="170.00" class="modal-input">
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" style="flex: 2; background: #27ae60; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-weight: bold;">Save Patient</button>
                    <button type="button" onclick="document.getElementById('patientModal').style.display='none'" style="flex: 1; background: #eee; border: none; padding: 12px; border-radius: 5px; cursor: pointer; color: #333;">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editPatientModal" class="modal-overlay">
        <div class="modal-container">
            <h3 style="margin-top: 0; color: #1a2e1a;">Edit Patient Details</h3>
            <form id="editPatientForm" method="POST">
                @csrf
                @method('PUT')
                <label style="font-size: 13px; color: #666;">First Name</label>
                <input type="text" name="FirstName" id="editFirstName" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Middle Name</label>
                <input type="text" name="MiddleName" id="editMiddleName" class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Last Name</label>
                <input type="text" name="LastName" id="editLastName" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Email Address</label>
                <input type="email" name="Email" id="editEmail" required class="modal-input">
                
                <label style="font-size: 13px; color: #666;">Phone Number</label>
                <input type="text" name="Phone" id="editPhone" class="modal-input">

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label style="font-size: 13px; color: #666;">Age</label> <input type="number" name="Age" id="editAge" class="modal-input">
                    </div>
                    <div style="flex: 1;">
                        <label style="font-size: 13px; color: #666;">Gender</label>
                        <select name="Gender" id="editGender" class="modal-input" style="height: 40px;">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label style="font-size: 13px; color: #666;">Birth Date</label>
                        <input type="date" name="BirthDate" id="editBirthDate" class="modal-input">
                    </div>
                    <div style="flex: 1;">
                        <label style="font-size: 13px; color: #666;">Blood Type</label>
                        <select name="BloodType" id="editBloodType" class="modal-input" style="height: 40px;">
                            <option value="">Select</option>
                            <option value="A+">A+</option><option value="A-">A-</option>
                            <option value="B+">B+</option><option value="B-">B-</option>
                            <option value="O+">O+</option><option value="O-">O-</option>
                            <option value="AB+">AB+</option><option value="AB-">AB-</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label style="font-size: 13px; color: #666;">Height (cm)</label>
                        <input type="number" step="0.01" name="Height" id="editHeight" class="modal-input">
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" style="flex: 2; background: #f39c12; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-weight: bold;">Update Records</button>
                    <button type="button" onclick="document.getElementById('editPatientModal').style.display='none'" style="flex: 1; background: #eee; border: none; padding: 12px; border-radius: 5px; cursor: pointer; color: #333;">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="viewModal" class="modal-overlay">
        <div class="modal-container" style="width: 500px;">
            <h2 id="viewPatientName" style="margin-top: 0; color: #1a2e1a; font-size: 20px;">Patient Profile</h2>
            <hr style="border: 0; border-top: 1px solid #edf2ef; margin: 15px 0;">

            <div class="profile-container">
                <div class="detail-group">
                    <span class="detail-label">Email Address</span>
                    <span id="viewEmail" class="detail-value"></span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Phone Number</span>
                    <span id="viewPhone" class="detail-value"></span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Age</span> <span id="viewAge" class="detail-value detail-value-special"></span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Gender</span>
                    <span id="viewGender" class="detail-value"></span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Birth Date</span>
                    <span id="viewBirthDate" class="detail-value"></span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Blood Type</span>
                    <span id="viewBloodType" class="detail-value detail-value-special"></span>
                </div>
                <div class="detail-group">
                    <span class="detail-label">Height</span>
                    <div class="detail-value">
                        <span id="viewHeight" class="detail-value-special"></span> <span style="font-weight: normal; color: #555;">cm</span>
                    </div>
                </div>
            </div>

            <button onclick="document.getElementById('viewModal').style.display='none'" 
                    style="width: 100%; margin-top: 25px; background: #95a5a6; color: white; border: none; padding: 12px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: background 0.2s;">
                Close Profile
            </button>
        </div>
    </div>

    <script>
        function filterPatientTable() {
            const input = document.getElementById('patientSearchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('patientTable');
            if(!table) return;
            const rows = table.getElementsByClassName('patient-row');

            for (let i = 0; i < rows.length; i++) {
                const idCell = rows[i].getElementsByClassName('patient-id')[0].textContent.toLowerCase();
                const nameCell = rows[i].getElementsByClassName('patient-name')[0].textContent.toLowerCase();
                const emailCell = rows[i].getElementsByClassName('patient-email')[0].textContent.toLowerCase();

                if (idCell.includes(filter) || nameCell.includes(filter) || emailCell.includes(filter)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        function viewPatientDetails(patient) {
            const fullName = patient.FirstName + ' ' + (patient.MiddleName ? patient.MiddleName + ' ' : '') + patient.LastName;
            document.getElementById('viewPatientName').innerText = fullName;
            document.getElementById('viewEmail').innerText = patient.Email;
            document.getElementById('viewPhone').innerText = patient.Phone || 'N/A';
            document.getElementById('viewAge').innerText = patient.Age || 'N/A'; 
            
            if (patient.BirthDate) {
                const birthDateObj = new Date(patient.BirthDate);
                document.getElementById('viewBirthDate').innerText = birthDateObj.toLocaleDateString(undefined, {
                    year: 'numeric', month: 'long', day: 'numeric'
                });
            } else {
                document.getElementById('viewBirthDate').innerText = 'N/A';
            }
            
            document.getElementById('viewGender').innerText = patient.Gender || 'N/A';
            document.getElementById('viewHeight').innerText = patient.Height || 'N/A';
            document.getElementById('viewBloodType').innerText = patient.BloodType || 'N/A';
            document.getElementById('viewModal').style.display = 'flex';
        }

        function openEditModal(patient) {
            document.getElementById('editFirstName').value = patient.FirstName;
            document.getElementById('editMiddleName').value = patient.MiddleName || '';
            document.getElementById('editLastName').value = patient.LastName;
            document.getElementById('editEmail').value = patient.Email;
            document.getElementById('editPhone').value = patient.Phone || '';
            document.getElementById('editAge').value = patient.Age || ''; 
            
            if(patient.BirthDate) {
                document.getElementById('editBirthDate').value = patient.BirthDate.split('T')[0];
            }

            document.getElementById('editGender').value = patient.Gender || '';
            document.getElementById('editHeight').value = patient.Height || '';
            document.getElementById('editBloodType').value = patient.BloodType || '';

            const form = document.getElementById('editPatientForm');
            form.action = `/patients/${patient.PatientID}`;

            document.getElementById('editPatientModal').style.display = 'flex';
        }
    </script>

</body>
</html>