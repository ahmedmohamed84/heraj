<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'city_id',
        'title',
        'slug',
        'description',
        'price',
        'phone',
        'status',
        'image',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(ServiceImage::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_service')->withPivot('value');
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
}
