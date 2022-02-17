<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsOtp extends Model
{
    protected $table = 'sms_otps';

    protected $fillable = [
        'phone', 'otp', 'token', 'ban_time', 'resend_otp_count'
    ];
}
