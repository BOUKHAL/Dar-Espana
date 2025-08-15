<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParascolaireController extends Controller
{
    public function index()
    {
        return view('parascolaire.index');
    }

    public function create()
    {
        return view('parascolaire.create');
    }

    public function edit(string $id)
    {
        return view('parascolaire.edit');
    }
}
