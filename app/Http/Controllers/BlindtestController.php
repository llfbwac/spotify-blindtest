<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Session;
use Illuminate\Http\Request;

class BlindtestController extends Controller
{
    public function play($sessionId)
    {
        // dd($sessionId);

        $session = Session::findOrFail($sessionId);
        // $sessionTracks = $session->sessionTracks;

        // dd($session->sessionTracks);

        return Inertia::render('Blindtest/Play', [
            // 'test' => true,
            'session' => $session,
            // 'sessionTrackResponse' => $sessionTrackResponse,
        ]);

    }
}