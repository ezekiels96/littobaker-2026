<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

        protected $fillable = [
            'name', 'title', 'description', 'price', 'quantity_type','sort_order',
        ];

        public function images(): HasMany
        {
            return $this->hasMany(MenuImage::class);
        }

        public function variations(): HasMany
        {
            return $this->hasMany(Variation::class);
        }

        public function addOns(): HasMany
        {
            return $this->hasMany(AddOn::class);
        }
}
