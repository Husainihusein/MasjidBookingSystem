<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'name',
        'ic',
        'email',
        'phone',
        'purpose',
        'booking_date',
        'start_time',
        'end_time',
        'price',
        'status',
        'account_number',  // ✅ add this
        'proof_file',
        'rejection_reason',
        'refund_proof',    // ✅ and this
    ];
}
