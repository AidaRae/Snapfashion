<?php

namespace App\Models;

use ArrayAccess;
use Illuminate\Database\Eloquent\Model;

/**
 * Dedicated model for website settings.
 *
 * Implements ArrayAccess so existing Blade templates can keep using
 * $settings['site_name'] syntax without any view changes.
 */
class SiteSetting extends Model implements ArrayAccess
{
    protected $fillable = [
        'site_name', 'site_title', 'site_address', 'description', 'timezone',
        'keywords', 'meta_author', 'google_analytics', 'facebook_pixel', 'custom_header_code',
        'logo', 'favicon',
        'phone_num', 'contact_instagram',
        'banner_enabled', 'banner_tag', 'banner_title', 'banner_subtitle',
        'banner_button_text', 'banner_link', 'banner_image',
        'banner_bg_color', 'banner_text_color',
        'home_slide_1', 'home_slide_2', 'home_slide_3', 'home_slide_4', 'home_slide_5',
    ];

    protected $casts = [
        'banner_enabled' => 'boolean',
    ];

    // ── ArrayAccess implementation ──
    // Allows $settings['site_name'] to work in Blade templates

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->getAttribute($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->setAttribute($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[$offset]);
    }
}
