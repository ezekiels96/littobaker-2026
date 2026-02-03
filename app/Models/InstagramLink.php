<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstagramLink extends Model
{
    protected $fillable = [
        'label',
        'post_url',
        'image_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
