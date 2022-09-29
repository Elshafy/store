<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Import extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}