<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Etudiant;
use App\Models\Centre;
use App\Models\Option;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\NotificationMail;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with(['centre', 'option', 'filiere', 'expediteur'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $centres = Centre::where('actif', true)->with('options')->get();
        $options = Option::where('actif', true)->get();
        $filieres = Filiere::where('actif', true)->get();

        return view('notifications.index', compact('notifications', 'centres', 'options', 'filieres'));
    }

    public function create()
    {
        $centres = Centre::where('actif', true)->with('options')->get();
        $options = Option::where('actif', true)->get();
        $filieres = Filiere::where('actif', true)->get();
        $etudiants = Etudiant::with(['centre', 'option', 'filiere'])->get();

        return view('notifications.create', compact('centres', 'options', 'filieres', 'etudiants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'message' => 'required|string',
            'type_destinataire' => 'required|in:tous,etudiant_specifique,centre,option,filiere',
            'destinataire_specifique' => 'required_if:type_destinataire,etudiant_specifique|email|nullable',
            'centre_id' => 'required_if:type_destinataire,centre|exists:centres,id|nullable',
            'option_id' => 'required_if:type_destinataire,option|exists:options,id|nullable',
            'filiere_id' => 'required_if:type_destinataire,filiere|exists:filieres,id|nullable',
        ]);

        // Créer la notification
        $notification = Notification::create([
            'titre' => $request->titre,
            'message' => $request->message,
            'type_destinataire' => $request->type_destinataire,
            'destinataire_specifique' => $request->destinataire_specifique,
            'centre_id' => $request->centre_id,
            'option_id' => $request->option_id,
            'filiere_id' => $request->filiere_id,
            'envoye_par' => Auth::id(),
        ]);

        // Obtenir les destinataires selon le type
        $destinataires = $this->getDestinataires($notification);

        // Envoyer les emails
        $emailsEnvoyes = $this->envoyerEmails($notification, $destinataires);

        // Mettre à jour la notification
        $notification->update([
            'nombre_destinataires' => count($destinataires),
            'statut' => $emailsEnvoyes ? 'envoye' : 'echec',
            'envoye_le' => now()
        ]);

        if ($emailsEnvoyes) {
            return redirect()->route('notifications.index')
                ->with('success', 'Notification envoyée avec succès à ' . count($destinataires) . ' étudiant(s).');
        } else {
            return redirect()->route('notifications.index')
                ->with('error', 'Erreur lors de l\'envoi de la notification.');
        }
    }

    public function show(Notification $notification)
    {
        $notification->load(['centre', 'option', 'filiere', 'expediteur']);
        return view('notifications.show', compact('notification'));
    }

    public function getDestinataires(Notification $notification)
    {
        $query = Etudiant::query();

        switch ($notification->type_destinataire) {
            case 'tous':
                // Tous les étudiants
                break;
            
            case 'etudiant_specifique':
                $query->where('email', $notification->destinataire_specifique);
                break;
            
            case 'centre':
                $query->where('centre_id', $notification->centre_id);
                break;
            
            case 'option':
                $query->where('option_id', $notification->option_id);
                break;
            
            case 'filiere':
                $query->where('filiere_id', $notification->filiere_id);
                break;
        }

        return $query->get();
    }

    public function envoyerEmails(Notification $notification, $destinataires)
    {
        try {
            foreach ($destinataires as $etudiant) {
                Mail::to($etudiant->email)->send(new NotificationMail($notification, $etudiant));
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email: ' . $e->getMessage());
            return false;
        }
    }

    public function getEtudiantsByFilter(Request $request)
    {
        $query = Etudiant::query();

        if ($request->centre_id) {
            $query->where('centre_id', $request->centre_id);
        }

        if ($request->option_id) {
            $query->where('option_id', $request->option_id);
        }

        if ($request->filiere_id) {
            $query->where('filiere_id', $request->filiere_id);
        }

        $etudiants = $query->with(['centre', 'option', 'filiere'])->get();

        return response()->json([
            'count' => $etudiants->count(),
            'etudiants' => $etudiants->map(function ($etudiant) {
                return [
                    'id' => $etudiant->id,
                    'nom_complet' => $etudiant->full_name,
                    'email' => $etudiant->email,
                    'centre' => $etudiant->centre->nom,
                    'option' => $etudiant->option->nom,
                    'filiere' => $etudiant->filiere->nom
                ];
            })
        ]);
    }
}
