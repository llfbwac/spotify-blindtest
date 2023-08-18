<?php

namespace App\Models;

use App\Models\User;
use App\Models\SessionTrack;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Session extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'token',
        'status',
    ];

    /**
     * Get the post that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the session tracks for the session.
     */
    public function sessionTracks(): HasMany
    {
        return $this->hasMany(SessionTrack::class);
    }

    public function getRemainingTracksAttribute()
    {
        $count = 0;
        foreach ($this->sessionTracks as $sessionTrack) {

            if (!$sessionTrack->played) {
                $count++;
            }
        }

        return $count;
    }
}