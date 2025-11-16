<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'locale',
        'group',
        'key',
        'value',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // After a translation is saved or deleted, we clear the entire
        // database translations cache.
        static::saved(function ($translation) {
            Cache::forget('db_translations');
        });

        static::deleted(function ($translation) {
            Cache::forget('db_translations');
        });
    }
}