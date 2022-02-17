<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    protected $table = "certificate_templates";

    protected $fillable = [
        "type",
        "background_image",
        "additional_text",
    ];
}
