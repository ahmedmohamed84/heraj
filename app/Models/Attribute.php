<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($attribute) {
            $attribute->slug = Str::slug($attribute->name);
        });
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'attribute_service')->withPivot('value');
    }

    /**
     * The categories that this attribute can be assigned to.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'attribute_category');
    }
}
