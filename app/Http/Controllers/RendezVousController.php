<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendezVous;

class RendezVousController extends Controller
{
    public function index()
    {
        // On récupère les rendez-vous non validés (tu peux ajuster la condition selon tes besoins)
        $appointments = RendezVous::where('is_validated', false)->paginate(10);

        // On renvoie la vue avec la variable appointments
        return view('dashboard.index', compact('appointments'));
    }
}
