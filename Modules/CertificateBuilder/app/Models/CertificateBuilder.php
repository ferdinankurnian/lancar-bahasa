<?php

namespace Modules\CertificateBuilder\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CertificateBuilder\Database\factories\CertificateBuilderFactory;

class CertificateBuilder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

}
