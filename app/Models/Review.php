<?php

namespace App\Models;

use App\Models\User;
use App\Models\Vila;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vila_id',
        'booking_id',
        'rating',
        'comment'];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vila(): BelongsTo
    {
        return $this->belongsTo(Vila::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
