<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuImage extends Model
{
    protected $fillable = ['menu_id', 'image_url'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
