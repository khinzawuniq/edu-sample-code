<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = "bank_accounts";

    protected $fillable = [
        "bank_name",
        "bank_account",
        "bank_user",
        "additional_note",
        "bank_logo",
        "created_by",
        "updated_by",
    ];

    public function createdBy()
    {
      return $this->belongsTo(User::class,'created_by','id');
    }
    
    public function updatedBy()
    {
      return $this->belongsTo(User::class,'updated_by','id');
    }
}
