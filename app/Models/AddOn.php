<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddOn extends Model
{
    protected $fillable = ['menu_id', 'name'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
