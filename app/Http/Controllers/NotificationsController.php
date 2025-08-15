<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        return view('notifications.index');
    }

    public function create()
    {
        return view('notifications.create');
    }

    public function edit(string $id)
    {
        return view('notifications.edit');
    }
}
