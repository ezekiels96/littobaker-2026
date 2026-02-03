<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variation extends Model
{
    protected $fillable = ['menu_id', 'name', 'price'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
