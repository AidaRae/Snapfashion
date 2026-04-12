<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'description',
        'price', 'sale_price', 'stock', 'image', 'hover_image', 'is_active', 'featured',
        'max_purchase_qty', 'low_stock_qty', 'unit', 'is_purchasable', 'show_stock_out', 'is_refundable',
        'sizes', 'colors',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'featured' => 'boolean',
        'is_purchasable' => 'boolean',
        'show_stock_out' => 'boolean',
        'is_refundable' => 'boolean',
        'sizes' => 'array',
        'colors' => 'array',
    ];

    // ── Relationships ──

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // ── Scopes ──

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // ── Accessors ──

    /**
     * Returns sale_price if set, otherwise regular price.
     */
    public function getEffectivePriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }
}
