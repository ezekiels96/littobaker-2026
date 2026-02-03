<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = [
        'title', 'caption', 'image_url', 'cloudinary_public_id',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
