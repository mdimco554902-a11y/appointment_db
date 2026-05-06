<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        // 1. Validate the incoming request
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Use a transaction to ensure both User and Patient are created or none at all
            DB::beginTransaction();

            // 2. Create the User (Login Credentials)
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'patient', // Default role for new registrations
            ]);

            // 3. Optional: Auto-create a basic Patient profile record
            // This links the login user to the medical records side
            Patient::create([
                'FirstName' => $request->name,
                'LastName'  => '', // User can update this later in profile
                'Email'     => $request->email,
                // These will be filled by the user later or during booking
                'MiddleName'=> null,
                'Phone'     => null,
                'Gender'    => null,
                'Age'       => null,
                'BirthDate' => null,
            ]);

            DB::commit();

            // 4. Log the user in immediately
            Auth::login($user);

            // 5. Redirect to the dashboard
            return redirect()->route('dashboard')->with('success', 'Account created successfully! Welcome to HealthCare Plus.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['msg' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
}