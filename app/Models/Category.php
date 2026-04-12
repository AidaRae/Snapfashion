<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'title', 'slug', 'description', 'image', 'thumbnail', 'icon', 'is_active', 'parent_id', 'sort'];

    protected $casts = [
        'is_active' => 'boolean',
        'parent_id' => 'integer',
        'sort' => 'integer',
    ];

    // ── Relationships ──

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // ── Scopes ──

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoots($query)
    {
        return $query->where('parent_id', 0);
    }
}
