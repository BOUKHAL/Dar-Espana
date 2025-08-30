<?php

namespace App\Http\Controllers;

use App\Mail\NameOfMailer;
use App\Models\Centre;
use App\Models\Option;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class StudentsController extends Controller
{
        public function index()
    {
        //
        $students = Student::all();
        $centres = Centre::all();
        $options = Option::all();
        return view('studentsEmail.tableOfStdents', compact('students', 'centres', 'options'));
    }
    // public function generate(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //     ]);

    //     // Generate email
    //     $baseEmail = strtolower(Str::slug($request->name));
    //     $email = $baseEmail . '@darespania.com';

    //     // Ensure email uniqueness
    //     $count = Student::where('email', 'like', $baseEmail . '%@darespana.com')->count();
    //     if ($count > 0) {
    //         $email = $baseEmail . ($count + 1) . '@darespana.com';
    //     }

    //     // Generate random password
    //     $password = Str::random(8);

    //     // Save student
    //     $student = Student::create([
    //         'name' => $request->name,
    //         'email' => $email,
    //         'password' => Hash::make($password),
    //     ]);

    //     // Send email with credentials
    //     Mail::to($email)->send(new NameOfMailer([
    //         'email' => $email,
    //         'password' => $password
    //     ]));

    //     return view('studentsEmail.create', compact('email', 'password'));


    //     // return response()->json([
    //     //     'success' => true,
    //     //     'data' => [
    //     //         'email' => $email,
    //     //         'password' => $password
    //     //     ]
    //     // ]);
    // }
    // public function create()
    // {
    //     $students = Student::latest()->paginate(15);
    //     return view('studentsEmail.create', compact('students'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //     ]);

    //     // Generate email
    //     $baseEmail = strtolower(Str::slug($request->name));
    //     $email = $baseEmail . '@darespania.com';

    //     // Ensure email uniqueness (fixed typo in domain)
    //     $count = Student::where('email', 'like', $baseEmail . '%@darespania.com')->count();
    //     if ($count > 0) {
    //         $email = $baseEmail . ($count + 1) . '@darespania.com';
    //     }

    //     // Generate random password
    //     $password = Str::random(8);

    //     // Save student
    //     $student = Student::create([
    //         'name' => $request->name,
    //         'email' => $email,
    //         'password' => Hash::make($password),
    //     ]);

    //     // Send email with credentials
    //     try {
    //         Mail::to($email)->send(new NameOfMailer([
    //             'name' => $request->name,
    //             'email' => $email,
    //             'password' => $password
    //         ]));
    //     } catch (\Exception $e) {
    //         // Log the error but continue
    //         \Log::error('Failed to send student credentials email: ' . $e->getMessage());
    //     }

    //     // Redirect back with success message and credentials
    //     return redirect()->route('studentsEmail.create')->with([
    //         'success' => 'Compte étudiant créé avec succès!',
    //         'email' => $email,
    //         'password' => $password
    //     ]);
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //     ]);

    //     $student = Student::where('email', $request->email)->first();

    //     if (!$student || !Hash::check($request->password, $student->password)) {
    //         return response()->json(['message' => 'Invalid credentials'], 401);
    //     }

    //     // Generate token for API auth (Sanctum)
    //     $token = $student->createToken('student-token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'Login successful',
    //         'token' => $token,
    //         'user' => $student
    //     ]);
    // }

    // // Optional: logout
    // public function logout(Request $request)
    // {
    //     $request->user()->currentAccessToken()->delete();
    //     return response()->json(['message' => 'Logged out successfully']);
    // }
}
