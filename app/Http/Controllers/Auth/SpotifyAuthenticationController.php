<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        $url .= http_build_query($data);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


        $result = curl_exec($curl);


        if (empty($result)) {
            // Request succeed
            return redirect(curl_getinfo($curl)['redirect_url']);
            // curl_close($curl);
        } else {
            // Request failed
            dd("Error: " . curl_error($curl));
        }
    }

    public function callbackLogin(Request $request)
    {
        // dd($request->query('code'));

        $code = $request->query('code');

        $url = 'https://accounts.spotify.com/api/token';
        $redirect_uri = 'http://localhost:8000/callback-login';


        $data = array(
            'code' => $code,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code'
        );


        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode(env('SPOTIFY_CLIENT_ID') . ':' . env('SPOTIFY_CLIENT_SECRET')),
        ]);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


        $resultCurlToken = curl_exec($curl);
        // dd($curl, $result);
        // dd(curl_getinfo($curl));

        if (curl_getinfo($curl)['http_code'] === 200) {
            $accessToken = json_decode($resultCurlToken, true)['access_token'];
            $curl = curl_init('https://api.spotify.com/v1/me');
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'Authorization: Bearer ' . $accessToken,
            ]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $resultCurlMe = curl_exec($curl);
            // debug($accessToken);
            $spotifyUser = json_decode($resultCurlMe, true);

            $user = User::firstOrCreate([
                'spotify_id' => $spotifyUser['id'],
                'spotify_name' => $spotifyUser['display_name'],
            ]);

            $user->spotify_access_token = $accessToken;

            $user->save();

            //TODO authentifier l'utilisateur récupéré
            Auth::login($user);

            return redirect('/dashboard');
            // header("Location: " . curl_getinfo($curl)['redirect_url']);
            // die;
        } else {
            // Request failed
            dd("Error: " . curl_error($curl));
        }

        curl_close($curl);
    }

    public function logout()
    {

    }
}