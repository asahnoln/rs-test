<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $perPage = 40;
    protected $hidden = ['created_at', 'updated_at'];

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class);
    }
}
