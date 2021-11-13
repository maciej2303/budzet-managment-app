<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function scopeDefault()
    {
        return $this->where('default', 1);
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}
