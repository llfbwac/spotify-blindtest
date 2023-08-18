<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Session;
use Illuminate\Http\Request;

class BlindtestController extends Controller
{
    public function play($sessionId)
    {
        $session = Session::findOrFail($sessionId);

        return Inertia::render('Blindtest/Play', [
            'session' => $session,
            'remaining_tracks' => $session->remaining_tracks,
            'test' => false,
        ]);

    }

    public function end($sessionId)
    {
        $session = Session::findOrFail($sessionId);

        return Inertia::render('Blindtest/End', [
            'session' => $session,
        ]);
    }
}