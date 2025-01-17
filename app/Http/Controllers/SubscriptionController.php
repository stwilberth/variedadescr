<?php

namespace anuncielo\Http\Controllers;

use anuncielo\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:subscribers,email']);

        Subscriber::create(['email' => $request->email]);

        return redirect()->back()->with('success', 'Te has suscrito exitosamente.');
    }
}
