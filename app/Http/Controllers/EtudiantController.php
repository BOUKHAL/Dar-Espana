<?php

namespace App\Http\Controllers;

use App\Mail\NameOfMailer;
use App\Models\Centre;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Option;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function index()
    {
        $etudiants = Etudiant::with(['centre', 'option', 'filiere'])->latest()->paginate(15);
        return view('studentsEmail.etudiantIndex', compact('etudiants'));
    }

    public function create()
    {
        //
        $centres = Centre::all();
        $options = Option::all();
        $filieres = Filiere::all();
        return view('studentsEmail.create', compact('centres', 'options', 'filieres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:etudiants,email',
            'telephone_etudiant' => 'nullable|string|max:20',
            'telephone_parents' => 'nullable|string|max:20',
            'type_baccalaureat' => 'nullable|string',
            'centre_id' => 'nullable|integer',
            'option_id' => 'nullable|integer',
            'filiere_id' => 'nullable|integer',
        ]);

        // === Generate email from prenom.nom ===
        $baseEmail = strtolower(Str::slug($request->prenom . '.' . $request->nom));
        $email = $baseEmail . '@darespania.com';

        // Ensure uniqueness
        $count = Student::where('email', 'like', $baseEmail . '%@darespania.com')->count();
        if ($count > 0) {
            $email = $baseEmail . ($count + 1) . '@darespania.com';
        }

        // === Generate random password ===
        $plainPassword = Str::random(8); // generate random password

        $student = Student::create([
            'email' => $email,
            'password' => Hash::make($plainPassword),
            'plain_password' => $plainPassword,     // unhashed for display
        ]);



        // === Then create Etudiant linked to Student ===
        $etudiant = Etudiant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone_etudiant' => $request->telephone_etudiant,
            'telephone_parents' => $request->telephone_parents,
            'type_baccalaureat' => $request->type_baccalaureat,
            'centre_id' => $request->centre_id,
            'option_id' => $request->option_id,
            'filiere_id' => $request->filiere_id,
            'student_id' => $student->id,
        ]);


        // === Send credentials email ===
        // try {
        //     Mail::to($email)->send(new NameOfMailer([
        //         'nom' => $request->nom,
        //         'prenom' => $request->prenom,
        //         'email' => $email,
        //         'password' => $plainPassword
        //     ]));
        // } catch (\Exception $e) {
        //     \Log::error('Failed to send credentials: ' . $e->getMessage());
        // }

        return redirect()->route("etudiant.index")->with([
            'success' => 'Compte étudiant créé avec succès!',
            'email' => $email,
            'password' => $plainPassword
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Etudiant $etudiant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etudiant $etudiant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etudiant $etudiant)
    {
        //
    }
}
