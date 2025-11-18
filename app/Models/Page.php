<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Page extends Model
{
    protected $fillable = [
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function translation(): HasOne
    {
        return $this->hasOne(PageTranslation::class)->where('locale', app()->getLocale());
    }

    // Accessor for a robust title
    public function getTranslatedTitleAttribute(): string
    {
        return $this->translation->title ?? $this->translations->first()->title ?? __('No Title');
    }

    // Accessor for a robust slug
    public function getTranslatedSlugAttribute(): string
    {
        return $this->translation->slug ?? $this->translations->first()->slug ?? '';
    }
}
