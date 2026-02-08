<?php

namespace App\Models;

use App\Models\User;
use App\Models\Review;
use App\Models\Booking;
use App\Models\VilaImage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vila extends Model
{
    //
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'facilities',
        'description',
        'address',
        'province_id',
        'regency_id',
        'price',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(VilaImage::class);
    }

    public function setImageAttribute($value)
    {
        if ($value && is_object($value)) {

            if ($this->exists && $this->getOriginal('image')) {
                Storage::disk('public')->delete($this->getOriginal('image'));
            }

            $uniqueName = 'vila_' . time() . '_' . Str::random(5) . '_' . $value->getClientOriginalName();

            $value->storeAs('image/vila', $uniqueName, 'public');

            $this->attributes['image'] = 'image/vila/' . $uniqueName;
        }
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    protected $appends = ['average_rating', 'total_reviews_count'];

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
    public function getTotalReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}
