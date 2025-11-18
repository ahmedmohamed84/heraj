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

    /**
     * Get the IDs of the current category and all its descendants.
     *
     * @return array
     */
    public function getDescendantIdsAndSelf()
    {
        $allCategories = Category::all();
        $descendants = collect();
        $this->getAllDescendants($this->id, $allCategories, $descendants);
        return $descendants->pluck('id')->push($this->id)->all();
    }

    /**
     * Recursively find all descendants for a given parent ID from a collection of categories.
     *
     * @param int $parentId
     * @param \Illuminate\Support\Collection $allCategories
     * @param \Illuminate\Support\Collection $descendants
     */
    private function getAllDescendants($parentId, $allCategories, &$descendants)
    {
        $children = $allCategories->where('parent_id', $parentId);
        foreach ($children as $child) {
            $descendants->push($child);
            $this->getAllDescendants($child->id, $allCategories, $descendants);
        }
    }
}
