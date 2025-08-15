<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanificationController extends Controller
{
    public function index()
    {
        return view('planification.index');
    }

    public function create()
    {
        return view('planification.create');
    }

    public function edit(string $id)
    {
        return view('planification.edit');
    }
}
