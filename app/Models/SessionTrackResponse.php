<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SessionTrackResponse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'session_track_id',
        'status',
    ];

    /**
     * Get the session that owns the session track.
     */
    public function sessionTrack(): BelongsTo
    {
        return $this->belongsTo(SessionTrack::class);
    }
}