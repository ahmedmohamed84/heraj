<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'attribute_id',
        'value',
    ];
}
