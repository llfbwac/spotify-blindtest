<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\SessionTrack;
use Illuminate\Http\Request;
use App\Models\SessionTrackResponse;
use Illuminate\Support\Facades\Auth;

class SessionTrackResponseController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(int $sessionTrackId)
    {
        $sessionTrack = SessionTrack::findOrFail($sessionTrackId);


        // dd('create response' . $sessionTrack->spotify_track_name);

        // dd($sessionTrack);

        return Inertia::render('SessionTrackResponses/Create', [
            // 'test' => true,
            'sessionTrack' => $sessionTrack,
            // 'sessionTrackResponse' => $sessionTrackResponse,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $sessionTrack = SessionTrack::findOrFail($sessionTrackId);

        $sessionTrackResponse = SessionTrackResponse::create([
            'user_id' => Auth::user()->id,
            'session_track_id' => $sessionTrack->id,
            'status' => 'jsp'
        ]);

        $validated = $request;
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}