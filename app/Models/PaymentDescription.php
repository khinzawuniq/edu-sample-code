<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDescription extends Model
{
    protected $table = "payment_descriptions";

    protected $fillable = [
        'pay_name',
        'status',
    ];
}
