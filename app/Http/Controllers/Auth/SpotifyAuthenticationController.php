<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class SpotifyAuthenticationController extends Controller
{

    public function login()
    {
        // dd('aie');
        $url = 'https://accounts.spotify.com/authorize?';
        $redirect_uri = 'http://localhost:8000/callback-login';
        $state = bin2hex(random_bytes(5)); //
        $scope = 'user-read-private user-read-email user-library-read user-top-read';

        $data = array(
            'response_type' => 'code',
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'scope' => $scope,
            'redirect_uri' => $redirect_uri,
            'state' => $state
        );

        $url = 'https://accounts.spotify.com/authorize?' . http_build_query($data);

        return redirect($url);
    }

    public function callbackLogin(Request $request)
    {
        $code = $request->query('code');

        $url = 'https://accounts.spotify.com/api/token';
        $redirect_uri = 'http://localhost:8000/callback-login';

        $data = array(
            'code' => $code,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code',
        );

        $response = Http::asForm()->withBasicAuth(env('SPOTIFY_CLIENT_ID'), env('SPOTIFY_CLIENT_SECRET'))->post($url, $data);

        if ($response->successful()) {
            $accessToken = json_decode($response->body(), true)['access_token'];
            $url = 'https://api.spotify.com/v1/me';

            $response = Http::withToken($accessToken)->get($url);

            $spotifyUser = json_decode($response->body(), true);

            $user = User::firstOrCreate([
                'spotify_id' => $spotifyUser['id'],
                'spotify_name' => $spotifyUser['display_name'],
            ]);

            $user->spotify_access_token = $accessToken;

            $user->save();

            //Authentification de l'utilisateur récupéré/créé
            Auth::login($user);

            return redirect()->route('dashboard');
        }
        dd("Error: ");
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}