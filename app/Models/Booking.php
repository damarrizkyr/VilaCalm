<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vila;
use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    //
    protected $fillable = [
        'booking_code',
        'vila_id',
        'user_id',
        'check_in',
        'check_out',
        'total_days',
        'total_price',
        'guest_count',
        'payment_deadline',
        'status',
        'payment_status',
        'expired_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'expired_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vila(): BelongsTo
    {
        return $this->belongsTo(Vila::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public static function generateBookingCode(): string
    {
        do {
            $code = 'BK' . strtoupper(uniqid());
        } while (self::where('booking_code', $code)->exists());

        return $code;
    }

    public static function paymentDeadline()
    {
        return Carbon::now()->addHours(1);
    }

    public function cancelIfPaymentExpired()
    {
        if (
            $this->payment_status === 'unpaid' &&
            now()->greaterThan($this->payment_deadline)
        ) {
            $this->update([
                'payment_status' => 'expired',
                'status' => 'canceled',
            ]);
        }
    }

    public function updateStatusByTime()
    {
        $now = now();

        if (
            $this->payment_status === 'paid' &&
            $this->status === 'pending' &&
            $now->greaterThanOrEqualTo(Carbon::parse($this->rental_date))
        ) {
            $this->update(['status' => 'confirmed']);
        }
        if (
            $this->status === 'confirmed' &&
            $now->greaterThan(Carbon::parse($this->return_date))
        ) {
            $this->update(['status' => 'completed']);
        }
    }

    public function canBeCanceled()
    {
        return $this->payment_status === 'unpaid'
            && $this->status === 'pending';
    }

    public function canBePaid()
    {
        return $this->payment_status === 'unpaid'
            && $this->status === 'pending'
            && now()->lessThanOrEqualTo($this->payment_deadline);
    }

    public function isFinished()
    {
        if ($this->status === 'confirmed' && now()->gt($this->check_out)) {
            $this->update(['status' => 'completed']);
            return true;
        }

        return $this->status === 'completed';
    }
}
