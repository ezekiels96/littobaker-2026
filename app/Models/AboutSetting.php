<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    protected $fillable = ['hero_heading', 'hero_tagline', 'content', 'image_url'];

    /** Always returns the single row, creating it if it doesn't exist. */
    public static function getInstance(): static
    {
        $instance = static::first();
        if (!$instance) {
            $instance = static::create([
                'hero_heading' => 'about littobaker',
                'hero_tagline' => 'asian-inspired sweet treats made with love ♡',
                'content'      => '<p>Hi! I\'m the baker behind littobaker. Based in Sunnyvale, CA, I craft Asian-inspired sweet treats made with love ♡</p>',
                'image_url'    => null,
            ]);
        }
        return $instance;
    }
}
