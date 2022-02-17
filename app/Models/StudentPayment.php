<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    protected $table = "student_payments";

    protected $fillable = [
        'student_id',
        'course_id',
        'payment_type',
        'payment_description',
        'installment_time',
        'name',
        'email',
        'phone',
        'payment_screenshot',
        'approve_status',
        'pay_amount',
        'pay_date',
        'remark',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id')->withDefault([
            'name' => null,
        ]);
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','id')->withDefault([
            'course_name' => null,
        ]);
    }

    public function paymentType()
    {
        return $this->belongsTo(BankAccount::class,'payment_type','id')->withDefault([
            'bank_name' => null,
        ]);
    }
    
    public function payType()
    {
        return $this->belongsTo(PaymentDescription::class,'payment_description','id')->withDefault([
            'pay_name' => null,
        ]);
    }

}
