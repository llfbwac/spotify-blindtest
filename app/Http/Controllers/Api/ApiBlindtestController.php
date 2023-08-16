<?php

namespace App\Http\Controllers\Api;

use App\Models\SessionTrack;
use Inertia\Inertia;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiBlindtestController extends Controller
{

    public function testApi()
    {
        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA',
        ]);
    }

    public function getNextSessionTrack($sessionId)
    {
        $nextSessionTrack = SessionTrack::where('session_id', $sessionId)
            ->where('played', false)
            ->orderBy('id')->first();

        return response()->json([
            'track' => $nextSessionTrack,
        ]);
    }

    public function sessionTrackSucceed($sessionId, $sessionTrackId)
    {
        $session = Session::findOrFail($sessionId);

        $sessionTrack = SessionTrack::findOrFail($sessionTrackId);

        // pour éviter de marquer plusieurs fois des points sur une même track
        if ($sessionTrack->played != true) {
            $session->score += 1;
            $session->save();

            $sessionTrack->played = true;
            $sessionTrack->save();
        }

    }

    public function sessionTrackFailed($sessionId, $sessionTrackId)
    {
        $session = Session::findOrFail($sessionId);

        $sessionTrack = SessionTrack::findOrFail($sessionTrackId);

        // pour éviter de marquer plusieurs fois des points sur une même track
        if ($sessionTrack->played != true) {
            $sessionTrack->played = true;
            $sessionTrack->save();
        }

    }
}