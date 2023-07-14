<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\SessionTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        $accessToken = Auth::user()->spotify_access_token;
        $curl = curl_init('https://api.spotify.com/v1/me/top/tracks');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: Bearer ' . $accessToken,
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);

        $session = Session::create([
            'user_id' => Auth::user()->id,
            'token' => bin2hex(random_bytes(5)),
            'status' => 'started'
        ]);

        $session->save();
        // debug($accessToken);

        $rawTracks = json_decode($result, true);

        dd($rawTracks['items'][0]);

        foreach ($rawTracks['items'] as $rawTrack) {
            $sessionTrack = SessionTrack::create([
                'session_id' => $session->id,
                'spotify_track_id' => $rawTrack['id'],
                'spotify_track_name' => $rawTrack['name'],
                'spotify_track_artist' => 'francky vincent',
            ]);

            $sessionTrack->save();
        }

        return redirect()->route('session-track-response.create', [$session->getNextTrack()->id]);
    }
}