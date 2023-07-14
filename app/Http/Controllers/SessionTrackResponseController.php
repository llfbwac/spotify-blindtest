<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\SessionTrack;
use Illuminate\Http\Request;

class SessionTrackResponseController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(int $sessionTrackId)
    {
        $sessionTrack = SessionTrack::find($sessionTrackId);
        // dd('create response' . $sessionTrack->spotify_track_name);

        return Inertia::render('SessionTrackResponses/Create', [
            'sessionTrack' => $sessionTrack,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd('store response');
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