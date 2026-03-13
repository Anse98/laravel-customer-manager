<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'notes',
    ];

    /**
     * The user who owns/created this customer record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
