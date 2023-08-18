<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\SessionTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        $accessToken = Auth::user()->spotify_access_token;
        $url = 'https://api.spotify.com/v1/me/top/tracks';

        $response = Http::withToken($accessToken)
            ->withQueryParameters([
                'limit' => 2,
            ])
            ->get($url);

        if ($response->successful()) {

            $session = Session::create([
                'user_id' => Auth::user()->id,
                'token' => bin2hex(random_bytes(5)),
                'status' => 'started'
            ]);

            $spotifyTracks = json_decode($response->body(), true);

            foreach ($spotifyTracks['items'] as $track) {
                $sessionTrack = SessionTrack::create([
                    'session_id' => $session->id,
                    'name' => $track['name'],
                    //TODO: save le bon artiste
                    'artist' => 'francky vincent',
                    'mp3_url' => $track['preview_url']
                ]);

                $sessionTrack->save();
            }

            return redirect()->route('blindtest.play', [$session->id]);

        }

        throw new \Exception('Une erreur est survenue lors de la récupération des tracks');
    }
}