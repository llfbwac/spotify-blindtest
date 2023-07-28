<?php

namespace App\Models;

use App\Models\Session;
use App\Models\SessionTrackResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SessionTrack extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'session_id',
        'name',
        'artist',
        'mp3_url',
    ];

    /**
     * Get the session that owns the session track.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    /**
     * Get the session tracks for the session.
     */
    public function sessionTrackResponses(): HasMany
    {
        return $this->hasMany(SessionTrackResponse::class);
    }
}