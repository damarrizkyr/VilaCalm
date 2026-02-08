<?php

namespace App\Models;

use App\Models\Vila;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VilaImage extends Model
{
    //
     protected $fillable = [
        'vila_id',
        'image_path',
        'is_primary',
    ];

    public function vila(): BelongsTo
    {
        return $this->belongsTo(Vila::class);
    }
}
