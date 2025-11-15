<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_category');
    }

    /**
     * Get all attributes for the category, including inherited attributes from parent categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getInheritedAttributes()
    {
        $parent = $this;
        $categoryIds = [];

        // Traverse up the category tree to collect all ancestor IDs
        while ($parent) {
            $categoryIds[] = $parent->id;
            $parent = $parent->parent;
        }

        // Fetch all unique attributes associated with the collected category IDs
        return Attribute::with('options')->whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })->get();
    }
}
