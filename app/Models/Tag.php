<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    public function galleryItems()
    {
        return $this->belongsToMany(GalleryItem::class);
    }

    public static function makeSlug(string $name): string
    {
        return Str::slug($name);
    }
}
