<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $fillable = [
        'hero_heading',
        'hero_image',
        'feature_heading',
        'feature_text',
        'feature_image',
    ];

    public static function getInstance(): static
    {
        $instance = static::first();
        if (!$instance) {
            $instance = static::create([
                'hero_heading'    => 'delicious asian inspired sweet treats',
                'hero_image'      => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1769070837/IMG_4829_bltwzk.jpg',
                'feature_heading' => 'specially made with love with every order',
                'feature_text'    => 'littobaker is a woman owned home based bakery that specializes in incorporating asian-inspired flavors into typical sweet treats.',
                'feature_image'   => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1769070835/IMG_0600_jpg_pcbyz2.jpg',
            ]);
        }
        return $instance;
    }
}
