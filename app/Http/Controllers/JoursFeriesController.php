<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JoursFeriesController extends Controller
{
    public function index()
    {
        return view('jours-feries.index');
    }

    public function create()
    {
        return view('jours-feries.create');
    }

    public function edit(string $id)
    {
        return view('jours-feries.edit');
    }
}
